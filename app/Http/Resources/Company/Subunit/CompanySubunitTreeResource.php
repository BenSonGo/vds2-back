<?php

namespace App\Http\Resources\Company\Subunit;

use App\Models\CompanySubunit;
use Illuminate\Contracts\Support\Arrayable;

class CompanySubunitTreeResource extends CompanySubunitResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        /** @var CompanySubunit $subunit */
        $subunit = $this->resource;
        $result = parent::toArray($request);

        if ($subunit->children->isNotEmpty()) {
            $result['children'] = new CompanySubunitTreeCollection($subunit->children);
        }

        return $result;
    }
}
