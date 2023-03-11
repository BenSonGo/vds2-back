<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'expected_effect' => 'string|max:255',
            'money_spent' => 'integer',
            'funding_source' => 'string|max:255',
            'implemented_date' => 'date',
        ];
    }
}
