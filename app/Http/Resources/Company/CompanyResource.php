<?php

namespace App\Http\Resources\Company;

use App\Formatters\ResourceFormatter;
use App\Http\Resources\Success\SuccessResource;
use App\Models\Company;
use Illuminate\Contracts\Support\Arrayable;

class CompanyResource extends SuccessResource
{
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        /** @var Company $company */
        $company = $this->resource;

        return [
            'id' => $company->id,
            'name' => $company->name,
            'created_at' => ResourceFormatter::formatDate($company->created_at)
        ];
    }
}
