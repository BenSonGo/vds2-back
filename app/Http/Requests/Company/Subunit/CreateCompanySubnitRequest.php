<?php

namespace App\Http\Requests\Company\Subunit;

use App\Models\Company;
use App\Models\CompanySubunit;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanySubnitRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:'.Company::getTableName().',id',
            'parent_id' => 'exists:'.CompanySubunit::getTableName().',id',
            'name' => 'required|string|max:255',
        ];
    }
}
