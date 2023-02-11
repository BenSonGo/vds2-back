<?php

namespace App\Http\Requests\Company\Subunit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanySubnitRequest extends FormRequest
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
