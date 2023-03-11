<?php

namespace App\Http\Requests\Indicator;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicatorRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'resource_id' => 'exists:'.Resource::getTableName().',id',
            'name' => 'string|max:255',
        ];
    }
}
