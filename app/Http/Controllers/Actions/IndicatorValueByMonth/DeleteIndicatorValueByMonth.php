<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\Http\Responses\SuccessJsonResponse;
use App\Models\IndicatorValueByMonth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class DeleteIndicatorValueByMonth
{
    public function __invoke(IndicatorValueByMonth $indicatorValueByMonth): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($indicatorValueByMonth->company_id)) {
            throw new \RuntimeException("Company is not assigned to user");
        }

        if ($user->companyIndicators->doesntContain($indicatorValueByMonth->indicator_id)) {
            throw new \RuntimeException("Indicator is not assigned to user");
        }

        $indicatorValueByMonth->delete();
        return new SuccessJsonResponse();
    }
}
