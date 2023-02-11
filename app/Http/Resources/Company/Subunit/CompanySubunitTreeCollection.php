<?php

namespace App\Http\Resources\Company\Subunit;

use App\Http\Resources\Success\SuccessCollection;

class CompanySubunitTreeCollection extends SuccessCollection
{
    public $collects = CompanySubunitTreeResource::class;
}
