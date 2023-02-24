<?php

namespace App\Http\Controllers\Actions\CompanySubunitWorkDaysByMonth;

use App\Http\Requests\CompanySubunitWorkDaysByMonth\UpdateCompanySubunitWorkDaysByMonthRequest;
use App\Http\Resources\Company\Subunit\WorkDaysByMonth\CompanySubunitWorkDaysByMonthResource;
use App\Models\CompanySubunitWorkDaysByMonth;

final class UpdateCompanySubunitWorkDaysByMonth
{
    public function __invoke(
        CompanySubunitWorkDaysByMonth              $workDaysByMonth,
        UpdateCompanySubunitWorkDaysByMonthRequest $request,
    ): CompanySubunitWorkDaysByMonthResource
    {
        // TODO: normal validation of work days on save
        $workDaysByMonth->update([
            'work_days' => $request->get('work_days'),
        ]);

        return new CompanySubunitWorkDaysByMonthResource($workDaysByMonth);
    }
}
