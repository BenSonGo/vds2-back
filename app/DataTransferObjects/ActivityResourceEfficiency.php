<?php

namespace App\DataTransferObjects;

final readonly class ActivityResourceEfficiency
{
    public function __construct(
        public string $resourceName,
        public ResourceConsumptionAndCost $currentSituation,
        public ResourceConsumptionAndCost $afterActivityImplementation,
        public ResourceConsumptionAndCost $economy,
    ) {
    }
}
