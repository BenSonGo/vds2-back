<?php

namespace App\Services;

use App\DataTransferObjects\ActivityEfficiency;
use App\DataTransferObjects\ActivityResourceEfficiency;
use App\DataTransferObjects\ResourceConsumptionAndCost;
use App\Models\Activity;
use App\Models\Indicator;
use App\Models\Resource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class FormActivityEfficiencyService
{
    /**
     * @param Collection<Resource> $resources
     */
    public function __invoke(Collection $resources, Activity $activity): ActivityEfficiency
    {
        $implementedDate = $activity->implemented_date;
        $yearsCount = Carbon::now()->diffInYears($implementedDate);
        $activityResourceEfficiencies = collect([]);

        /** @var Resource $resource */
        foreach ($resources as $resource) {

            $currentSituation = $this->currentSituation($resource, $implementedDate);
            $afterImplementation = $this->afterImplementation($resource, $implementedDate);

            $activityResourceEfficiencies->add(new ActivityResourceEfficiency(
                $resource->name,
                $currentSituation,
                $afterImplementation,
                $this->economy($currentSituation, $afterImplementation, $activity->money_spent, $yearsCount),
            ));
        }

        return new ActivityEfficiency(
            $activityResourceEfficiencies,
            $activityResourceEfficiencies->sum(
                fn (ActivityResourceEfficiency $resourceEfficiency) => $resourceEfficiency->economy->costs,
            ),
        );
    }

    private function currentSituation(Resource $resource, Carbon $activityImplementedDate): ResourceConsumptionAndCost
    {
        return new ResourceConsumptionAndCost(
            $this->resourceConsumptionBefore($resource, $activityImplementedDate),
            $this->resourceMoneyBefore($resource, $activityImplementedDate),
        );
    }

    private function afterImplementation(Resource $resource, Carbon $activityImplementedDate): ResourceConsumptionAndCost
    {
        return new ResourceConsumptionAndCost(
            $this->resourceConsumptionAfter($resource, $activityImplementedDate),
            $this->resourceMoneyAfter($resource, $activityImplementedDate),
        );
    }

    private function economy(
        ResourceConsumptionAndCost $before,
        ResourceConsumptionAndCost $after,
        int $activityMoneySpent,
        int $yearsAfterImplementation,
    ): ResourceConsumptionAndCost {
        return new ResourceConsumptionAndCost(
            $before->consumption - $after->consumption,
            $before->costs - ($after->costs + $activityMoneySpent) / $yearsAfterImplementation,
        );
    }

    private function resourceConsumptionBefore(Resource $resource, Carbon $date): int
    {
        return $resource->consumptionIndicators->average(function (Indicator $indicator) use ($date) {
            return $indicator->valueByMonths()
                ->select('value')
                ->whereDate('month', '<=', $date->toDateString())
                ->whereNull('company_subunit_id')
                ->groupBy('month')
                ->average('value');
        });
    }

    private function resourceMoneyBefore(Resource $resource, Carbon $date): int
    {
        return $resource->moneyIndicators->average(function (Indicator $indicator) use ($date) {
            return $indicator->valueByMonths()
                ->select('value')
                ->whereDate('month', '<=', $date->toDateString())
                ->whereNull('company_subunit_id')
                ->groupBy('month')
                ->average('value');
        });
    }

    private function resourceMoneyAfter(Resource $resource, Carbon $date): int
    {
        return $resource->moneyIndicators->average(function (Indicator $indicator) use ($date) {
            return $indicator->valueByMonths()
                ->select('value')
                ->whereDate('month', '>=', $date->toDateString())
                ->whereNull('company_subunit_id')
                ->groupBy('month')
                ->average('value');
        });
    }

    private function resourceConsumptionAfter(Resource $resource, Carbon $date): int
    {
        return $resource->consumptionIndicators->average(function (Indicator $indicator) use ($date) {
            return $indicator->valueByMonths()
                ->select('value')
                ->whereDate('month', '>=', $date->toDateString())
                ->whereNull('company_subunit_id')
                ->groupBy('month')
                ->average('value');
        });
    }
}
