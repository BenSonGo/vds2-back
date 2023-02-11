<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\DataTransferObjects\CreateIndicatorValueByMonthDTO;
use App\Http\Requests\IndicatorValueByMonth\CreateIndicatorValueByMonthRequest;
use App\Http\Resources\IndicatorValueByMonth\IndicatorValueByMonthResource;
use App\Models\User;
use App\Services\IndicatorValueByMonth\CreateIndicatorValueByMonthService;
use Illuminate\Support\Facades\Auth;

final class CreateIndicatorValueByMonth
{
    public function __invoke(
        CreateIndicatorValueByMonthRequest $request,
        CreateIndicatorValueByMonthService $createIndicatorValueByMonthService
    ): IndicatorValueByMonthResource {
        /** @var User $user */
        $user = Auth::user();

        $indicatorValueByMonth = $createIndicatorValueByMonthService(
            CreateIndicatorValueByMonthDTO::fromRequest($request),
            $user
        );

        return new IndicatorValueByMonthResource($indicatorValueByMonth);
    }
}
