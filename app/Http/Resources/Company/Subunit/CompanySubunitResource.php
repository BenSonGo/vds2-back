<?php

namespace App\Http\Resources\Company\Subunit;

use App\Formatters\ResourceFormatter;
use App\Http\Resources\Success\SuccessResource;
use App\Models\CompanySubunit;
use Illuminate\Contracts\Support\Arrayable;

class CompanySubunitResource extends SuccessResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        /** @var CompanySubunit $subunit */
        $subunit = $this->resource;

        return [
            'id' => $subunit->id,
            'company_id' => $subunit->company_id,
            'parent_id' => $subunit->parent_id,
            'name' => $subunit->name,
            'created_at' => ResourceFormatter::formatDate($subunit->created_at),
        ];
    }
}
