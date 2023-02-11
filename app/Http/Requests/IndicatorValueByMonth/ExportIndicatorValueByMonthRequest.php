<?php

namespace App\Http\Requests\IndicatorValueByMonth;

use App\Models\Company;
use App\Models\CompanySubunit;
use Illuminate\Foundation\Http\FormRequest;

class ExportIndicatorValueByMonthRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:'.Company::getTableName().',id',
            'company_subunit_id' => 'exists:'.CompanySubunit::getTableName().',id',
        ];
    }
}
