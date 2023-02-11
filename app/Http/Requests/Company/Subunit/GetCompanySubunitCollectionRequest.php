<?php

namespace App\Http\Requests\Company\Subunit;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class GetCompanySubunitCollectionRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:'.Company::getTableName().',id',
        ];
    }
}
