<?php

namespace App\Http\Resources\Indicator;

use App\Http\Resources\Success\SuccessCollection;

class IndicatorCollection extends SuccessCollection
{
    public $collects = IndicatorResource::class;
}
