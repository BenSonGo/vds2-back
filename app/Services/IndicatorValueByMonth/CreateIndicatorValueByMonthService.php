<?php

namespace App\Services\IndicatorValueByMonth;

use App\DataTransferObjects\CreateIndicatorValueByMonthDTO;
use App\DataTransferObjects\ValidatePersistenceIndicatorValueByMonthDTO;
use App\Models\IndicatorValueByMonth;
use App\Models\User;

final readonly class CreateIndicatorValueByMonthService
{
    public function __construct(private ValidateOnPersistenceService $validateService)
    {
    }

    public function __invoke(CreateIndicatorValueByMonthDTO $createData, ?User $user = null): IndicatorValueByMonth
    {
        $companySubunit = $createData->companySubunit;

        if ($user) {
            $this->validateService->__invoke(
                ValidatePersistenceIndicatorValueByMonthDTO::fromCreateData($user, $createData)
            );
        }

        $findDbData = [
            'company_id' => $createData->company->id,
            'indicator_id' => $createData->indicator->id,
            'month' => $createData->month,
        ];

        if ($companySubunit) {
            $findDbData['company_subunit_id'] = $companySubunit->id;
        }

        $dbCreateData = $findDbData;
        $dbCreateData['value'] = $createData->value;

        return IndicatorValueByMonth::updateOrCreate(
            $findDbData,
            $dbCreateData,
        );
    }
}
