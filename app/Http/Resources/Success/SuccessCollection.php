<?php

namespace App\Http\Resources\Success;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SuccessCollection extends ResourceCollection
{
    public $with = ['success' => 1];
}
