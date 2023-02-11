<?php

namespace App\DataTransferObjects;

use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final readonly class CreateIndicatorValueByMonthDTO
{
    public function __construct(
        public Company $company,
        public ?CompanySubunit $companySubunit,
        public Indicator $indicator,
        public int $value,
        public Carbon $month,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $companySubunitId = $request->get('company_subunit_id');

        return new self(
            Company::findOrFail($request->get('company_id')),
            $companySubunitId ? CompanySubunit::findOrFail($companySubunitId) : null,
            Indicator::findOrFail($request->get('indicator_id')),
            (float)$request->get('value') * 100,
            Carbon::create($request->get('month')),
        );
    }
}
