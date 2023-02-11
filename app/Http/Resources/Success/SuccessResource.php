<?php

namespace App\Http\Resources\Success;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public $additional = ['success' => 1];
}
