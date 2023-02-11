<?php

namespace App\Http\Resources\Company\Subunit;

use App\Http\Resources\Success\SuccessCollection;

class CompanySubunitCollection extends SuccessCollection
{
    public $collects = CompanySubunitResource::class;
}
