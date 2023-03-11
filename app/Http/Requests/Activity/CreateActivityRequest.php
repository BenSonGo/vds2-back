<?php

namespace App\Http\Requests\Activity;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
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
            'name' => 'required|string',
            'resource_id' => 'required|exists:'.Resource::getTableName().',id',
            'expected_effect' => 'string|max:255',
            'money_spent' => 'required|integer',
            'funding_source' => 'string|max:255',
            'implemented_date' => 'required|date',
        ];
    }
}
