<?php

namespace App\Http\Requests\Indicator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicatorRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
        ];
    }
}
