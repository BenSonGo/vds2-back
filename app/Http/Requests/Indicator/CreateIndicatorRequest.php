<?php

namespace App\Http\Requests\Indicator;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class CreateIndicatorRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'resource_id' => 'required|exists:'.Resource::getTableName().',id',
            'name' => 'required|string|max:255',
        ];
    }
}
