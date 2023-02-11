<?php

namespace App\Http\Requests\IndicatorValueByMonth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicatorValueByMonthRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
        ];
    }
}
