<?php

namespace App\Services\CompanySubunitWorkDaysByMonth;

use App\DataTransferObjects\CreateCompanySubunitWorkDaysByMonthDTO;
use App\Models\CompanySubunitWorkDaysByMonth;

final class CreateCompanySubunitWorkDaysByMonthService
{
    public function __invoke(CreateCompanySubunitWorkDaysByMonthDTO $dto): CompanySubunitWorkDaysByMonth
    {
        // TODO: normal validation of work days on save
        return CompanySubunitWorkDaysByMonth::create([
            'company_id' => $dto->companyId,
            'company_subunit_id' => $dto->companySubunitId,
            'work_days' => $dto->workDays,
            'month' => $dto->month,
        ]);
    }
}
