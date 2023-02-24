<?php

namespace App\Http\Resources\Company\Subunit\WorkDaysByMonth;

use App\Formatters\ResourceFormatter;
use App\Models\CompanySubunitWorkDaysByMonth;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanySubunitWorkDaysByMonthResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CompanySubunitWorkDaysByMonth $workDaysByMonth */
        $workDaysByMonth = $this->resource;

        return [
            'id' => $workDaysByMonth->id,
            'company_id' => $workDaysByMonth->company_id,
            'company_subunit_id' => $workDaysByMonth->company_subunit_id,
            'work_days' => $workDaysByMonth->work_days,
            'month' => ResourceFormatter::formatDate($workDaysByMonth->month),
        ];
    }
}
