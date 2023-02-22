<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\CompanySubunit;
use Illuminate\Console\Command;

class GenerateCompaniesAndSubunitsCommand extends Command
{
    protected $signature = 'generate:companies_and_subunits';

    protected $description = 'Generate companies and subunits';

    private function createSubunits(int $companyId, array $subUnitNames, ?CompanySubunit $parent = null): void
    {
        foreach ($subUnitNames as $key => $value) {

            if (is_array($value)) {
                $storeData = [
                    'company_id' => $companyId,
                    'name' => $key
                ];

                if ($parent) {
                    $storeData['parent_id'] = $parent->id;
                }

                $this->createSubunits($companyId, $value, CompanySubunit::updateOrCreate(
                    $storeData,
                    $storeData,
                ));
                continue;
            }

            $storeData = [
                'company_id' => $companyId,
                'name' => $value
            ];

            if ($parent) {
                $storeData['parent_id'] = $parent->id;
            }

            CompanySubunit::updateOrCreate($storeData, $storeData);
        }
    }

    public function handle(): int
    {
        $companyNameToSubunits = [
            'ANPGasStation' => [
                'Gas Stations' => [
                    'Shops' => [
                        'Reserve generator',
                    ],
                    'Office',
                    'Toilets',
                ],
                'Central Warehouse',
                'Oil Base',
                'Vehicle Base' => [
                    'Repair Station',
                ],
            ],

            'KLOGasStation' => [
                'Gas Stations' => [
                    'Shops',
                    'Cafe' => [
                        'Catering',
                        'Office',
                        'Toilets',
                    ],
                ],
                'Central Warehouse',
                'Oil Base',
                'Vehicle Base' => [
                    'Repair Station',
                ],
            ],

            'OKKOGasStation' => [
                'Gas Stations' => [
                    'Shops' => [
                        'Reserve generator',
                    ],
                    'Cafe' => [
                        'Catering',
                        'Office',
                        'Toilets',
                    ],
                ],

                'Central Warehouse',
                'Oil Base',
                'Vehicle Base' => [
                    'Repair Station',
                ],
            ],
        ];

        foreach ($companyNameToSubunits as $companyName => $subunitNames) {
            $company = Company::updateOrCreate(
                ['name' => $companyName],
                ['name' => $companyName],
            );

            if (is_array($subunitNames)) {
                $this->createSubunits($company->id, $subunitNames);
            }
        }

        return Command::SUCCESS;
    }
}
