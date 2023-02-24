<?php

namespace App\Http\Requests\CompanySubunitWorkDaysByMonth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanySubunitWorkDaysByMonthRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'work_days' => 'required|integer|between:0,31',
        ];
    }
}
