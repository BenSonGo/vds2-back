<?php

namespace App\Formatters;

use Illuminate\Support\Carbon;

final class ResourceFormatter
{
    public static function formatDate(Carbon $date): string
    {
        return $date->toDateString();
    }
}
