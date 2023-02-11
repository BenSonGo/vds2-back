<?php

namespace App\Http\Requests\Indicator;

use Illuminate\Foundation\Http\FormRequest;

class CreateIndicatorRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
