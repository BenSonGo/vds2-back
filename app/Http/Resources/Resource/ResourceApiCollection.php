<?php

namespace App\Http\Resources\Resource;

use App\Http\Resources\Success\SuccessCollection;

class ResourceApiCollection extends SuccessCollection
{
    public $collects = ResourceResource::class;
}
