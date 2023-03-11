<?php

namespace App\Http\Requests\IndicatorValueByMonth;

use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\Indicator;
use Illuminate\Foundation\Http\FormRequest;

class GetIndicatorValueByMonthCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'exists:'.Company::getTableName().',id',
            'company_subunit_id' => 'exists:'.CompanySubunit::getTableName().',id',
            'indicator_id' => 'exists:'.Indicator::getTableName().',id',
            'date_from' => 'date_format:Y-m-d',
            'date_to' => 'date_format:Y-m-d',
        ];
    }
}
