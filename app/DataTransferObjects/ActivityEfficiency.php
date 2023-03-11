<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Collection;

final readonly class ActivityEfficiency
{
    /**
     * @param Collection<ActivityResourceEfficiency> $resourceEfficiencies
     */
    public function __construct(
        public Collection $resourceEfficiencies,
        public int $totalMoneySavings,
    ) {
    }
}
