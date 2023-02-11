<?php

namespace App\DataTransferObjects;

use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\Indicator;
use App\Models\IndicatorValueByMonth;
use App\Models\User;
use Illuminate\Support\Carbon;

final readonly class ValidatePersistenceIndicatorValueByMonthDTO
{
    public function __construct(
        public User $user,
        public Company $company,
        public ?CompanySubunit $companySubunit,
        public Indicator $indicator,
        public int $value,
        public Carbon $month,
    ) {
    }

    public static function fromCreateData(User $user, CreateIndicatorValueByMonthDTO $createData): self
    {
        return new self(
            $user,
            $createData->company,
            $createData->companySubunit,
            $createData->indicator,
            $createData->value,
            $createData->month,
        );
    }

    public static function fromUpdateValue(
        User $user,
        IndicatorValueByMonth $indicatorValueByMonth,
        int $newValue,
    ): self {
        return new self(
            $user,
            $indicatorValueByMonth->company,
            $indicatorValueByMonth->companySubunit,
            $indicatorValueByMonth->indicator,
            $newValue,
            $indicatorValueByMonth->month,
        );
    }
}
