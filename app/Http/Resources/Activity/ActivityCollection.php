<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\Success\SuccessCollection;

class ActivityCollection extends SuccessCollection
{
    public $collects = ActivityResource::class;
}
