<?php

namespace App\Console\Commands\Generations;

use App\DataTransferObjects\CreateCompanySubunitWorkDaysByMonthDTO;
use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\CompanySubunitWorkDaysByMonth;
use App\Services\CompanySubunitWorkDaysByMonth\CreateCompanySubunitWorkDaysByMonthService;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateCompanySubunitWorkDaysForSeveralYearsCommand extends Command
{
    protected $signature = 'generate:company_subunits_work_days_for_several_years';

    public function handle(CreateCompanySubunitWorkDaysByMonthService $createWorkDaysService): int
    {
        $companies = Company::all();

        $period = CarbonPeriod::create(
            Carbon::now()->subYears(10),
            '1 month',
            Carbon::now()
        );

        /**
         * @var Company $company
         * @var CompanySubunitWorkDaysByMonth $workDaysByMonth
         * @var CompanySubunit $subunit
         * @var Carbon $month
         */

        foreach ($period as $month) {
            $month = $month->startOfMonth();

            foreach ($companies as $company) {
                $createWorkDaysService(new CreateCompanySubunitWorkDaysByMonthDTO(
                    $company->id,
                    null,
                    random_int(18, 22),
                    $month,
                ));

                foreach ($company->subunits as $subunit) {
                    $createWorkDaysService(new CreateCompanySubunitWorkDaysByMonthDTO(
                        $company->id,
                        $subunit->id,
                        random_int(18, 22),
                        $month,
                    ));
                }
            }
        }

        return Command::SUCCESS;
    }
}
