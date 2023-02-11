<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\DataTransferObjects\ValidatePersistenceIndicatorValueByMonthDTO;
use App\Http\Requests\IndicatorValueByMonth\UpdateIndicatorValueByMonthRequest;
use App\Http\Resources\IndicatorValueByMonth\IndicatorValueByMonthResource;
use App\Models\IndicatorValueByMonth;
use App\Models\User;
use App\Services\IndicatorValueByMonth\ValidateOnPersistenceService;
use Illuminate\Support\Facades\Auth;

final class UpdateIndicatorValueByMonth
{
    public function __invoke(
        IndicatorValueByMonth              $indicatorValueByMonth,
        UpdateIndicatorValueByMonthRequest $request,
        ValidateOnPersistenceService       $validateOnPersistenceService
    ): IndicatorValueByMonthResource {

        /** @var User $user */
        $user = Auth::user();
        $newValue = (float)$request->get('value') * 100;

        $validateOnPersistenceService(ValidatePersistenceIndicatorValueByMonthDTO::fromUpdateValue(
            $user,
            $indicatorValueByMonth,
            $newValue,
        ));

        $indicatorValueByMonth->update([
            'value' => $newValue,
        ]);

        return new IndicatorValueByMonthResource($indicatorValueByMonth);
    }
}
