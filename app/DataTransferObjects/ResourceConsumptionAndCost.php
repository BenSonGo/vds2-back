<?php

namespace App\DataTransferObjects;

final readonly class ResourceConsumptionAndCost
{
    public function __construct(
        public int $consumption,
        public int $costs,
    ) {
    }
}
