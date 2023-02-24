<?php

namespace App\Console\Commands\Generations;

use App\DataTransferObjects\CreateIndicatorValueByMonthDTO;
use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\Indicator;
use App\Services\IndicatorValueByMonth\CreateIndicatorValueByMonthService;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateIndicatorValuesForSeveralYearsCommand extends Command
{
    protected $signature = 'generate:indicator_values_for_several_years';

    public function handle(CreateIndicatorValueByMonthService $createIndicatorValueByMonthService): int
    {
        $companies = Company::all();

        $period = CarbonPeriod::create(
            Carbon::now()->subYears(10),
            '1 month',
            Carbon::now()
        );

        /**
         * @var Company $company
         * @var Indicator $indicator
         * @var CompanySubunit $subunit
         * @var Carbon $month
         */

        foreach ($period as $month) {
            $month = $month->startOfMonth();

            foreach ($companies as $company) {
                $users = $company->users;
                $indicators = collect();

                foreach ($users as $user) {
                    $indicators = $indicators->merge($user->companyIndicators);
                }

                $subunits = $company->subunits;

                foreach ($indicators as $indicator) {
                    $createIndicatorValueByMonthService(new CreateIndicatorValueByMonthDTO(
                        $company,
                        null,
                        $indicator,
                        $this->generateRandomValue($month, $indicator),
                        $month,
                    ));

                    foreach ($subunits as $subunit) {
                        $createIndicatorValueByMonthService(new CreateIndicatorValueByMonthDTO(
                            $company,
                            $subunit,
                            $indicator,
                            $this->generateRandomValue($month, $indicator, $subunit),
                            $month,
                        ));
                    }
                }
            }
        }

        return Command::SUCCESS;
    }

    private function generateRandomValue(
        Carbon $month,
        Indicator $indicator,
        ?CompanySubunit $subunit = null
    ): int {
        if ($subunit) {
            $from = 0;

            $ancestorIndicatorValue = $subunit->nearestAncestorIndicatorByMonthValue($indicator->id, $month);
            $siblingsSum = $subunit->siblingsIndicatorByMonthValuesSum($indicator->id, $month);

            $to = ($ancestorIndicatorValue - $siblingsSum) * 0.8;

        } else {
            $from = 9500;
            $to = 10000;
        }

        //TODO: maybe fix this xz
//        if ($from > $to) {
//            dd($from, $to, $ancestorIndicatorValue, $siblingsSum, $subunit->id);
//        }

        return random_int($from, $to);
    }
}
