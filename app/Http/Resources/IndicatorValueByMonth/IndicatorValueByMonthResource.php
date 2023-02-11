<?php

namespace App\Http\Resources\IndicatorValueByMonth;

use App\Formatters\ResourceFormatter;
use App\Http\Resources\Success\SuccessResource;
use App\Models\IndicatorValueByMonth;
use Illuminate\Contracts\Support\Arrayable;

class IndicatorValueByMonthResource extends SuccessResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        /** @var IndicatorValueByMonth $indicatorValue */
        $indicatorValue = $this->resource;

        return [
            'company_id' => $indicatorValue->company_id,
            'company_subunit_id' => $indicatorValue->company_subunit_id,
            'indicator_id' => $indicatorValue->indicator_id,
            'value' => $indicatorValue->value / 100,
            'month' => ResourceFormatter::formatDate($indicatorValue->month),
        ];
    }
}
