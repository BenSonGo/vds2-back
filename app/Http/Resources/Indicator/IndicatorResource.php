<?php

namespace App\Http\Resources\Indicator;

use App\Formatters\ResourceFormatter;
use App\Http\Resources\Success\SuccessResource;
use App\Models\Indicator;
use Illuminate\Contracts\Support\Arrayable;

class IndicatorResource extends SuccessResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        /** @var Indicator $indicator */
        $indicator = $this->resource;

        return [
            'id' => $indicator->id,
            'name' => $indicator->name,
            'created_at' => ResourceFormatter::formatDate($indicator->created_at)
        ];
    }
}
