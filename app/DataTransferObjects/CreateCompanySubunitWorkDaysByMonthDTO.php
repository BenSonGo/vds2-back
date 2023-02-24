<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final readonly class CreateCompanySubunitWorkDaysByMonthDTO
{
    public function __construct(
        public int $companyId,
        public ?int $companySubunitId,
        public int $workDays,
        public Carbon $month,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('company_id'),
            $request->get('company_subunit_id'),
            $request->get('work_days'),
            Carbon::create($request->get('month')),
        );
    }
}
