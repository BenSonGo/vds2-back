<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
