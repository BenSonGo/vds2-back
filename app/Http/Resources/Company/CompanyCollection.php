<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Success\SuccessCollection;

final class CompanyCollection extends SuccessCollection
{
    public $collects = CompanyResource::class;
}
