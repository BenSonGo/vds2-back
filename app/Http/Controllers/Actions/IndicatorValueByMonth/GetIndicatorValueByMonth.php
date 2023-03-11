<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndicatorValueByMonth\IndicatorValueByMonthResource;
use App\Models\IndicatorValueByMonth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class GetIndicatorValueByMonth extends Controller
{
    public function __invoke(IndicatorValueByMonth $indicatorValueByMonth): IndicatorValueByMonthResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($indicatorValueByMonth->company_id)) {
            throw new \RuntimeException("Company is not assigned to user");
        }

        if ($user->companyIndicators->doesntContain($indicatorValueByMonth->indicator_id)) {
            throw new \RuntimeException("Indicator is not assigned to user");
        }

        return new IndicatorValueByMonthResource($indicatorValueByMonth);
    }
}
