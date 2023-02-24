<?php

namespace App\Http\Requests\CompanySubunitWorkDaysByMonth;

use App\Models\Company;
use App\Models\CompanySubunit;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanySubunitWorkDaysByMonthRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:'.Company::getTableName().',id',
            'company_subunit_id' => 'exists:'.CompanySubunit::getTableName().',id',
            'work_days' => 'required|integer|between:0,31',
            'month' => 'required|date_format:Y-m-d',
        ];
    }
}
