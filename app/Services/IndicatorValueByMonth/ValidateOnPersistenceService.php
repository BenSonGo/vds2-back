<?php

namespace App\Services\IndicatorValueByMonth;

use App\DataTransferObjects\ValidatePersistenceIndicatorValueByMonthDTO;

final readonly class ValidateOnPersistenceService
{
    public function __invoke(ValidatePersistenceIndicatorValueByMonthDTO $dto): void
    {
        $user = $dto->user;
        $indicator = $dto->indicator;
        $company = $dto->company;
        $companySubunit = $dto->companySubunit;

        if ($user->doesntHaveCompany($company->id)) {
            throw new \RuntimeException("Company is not assigned to user");
        }

        if ($user->companyIndicators->doesntContain($indicator->id)) {
            throw new \RuntimeException("Indicator is not assigned to user");
        }

        if ($companySubunit) {
            if ($company->subunits->doesntContain($companySubunit->id)) {
                throw new \RuntimeException("Subunit is not assigned to company");
            }

            $this->validateSubunitTreeValues($dto);
        }
    }

    public function validateSubunitTreeValues(ValidatePersistenceIndicatorValueByMonthDTO $dto): void
    {
        $companySubunit = $dto->companySubunit;
        $indicator = $dto->indicator;
        $value = $dto->value;

        $nearestAncestorValue = $companySubunit->nearestAncestorIndicatorByMonthValue($indicator->id, $dto->month);

        if (!$nearestAncestorValue) {
            return;
        }

        $siblingsSum = $companySubunit->siblingsIndicatorByMonthValuesSum($indicator->id, $dto->month);

        if ($value + $siblingsSum > $nearestAncestorValue) {
            throw new \RuntimeException(sprintf(
                "Subunit + its siblings values sum can't be bigger than its nearest ancestor value. %s > %s! Possible value: %s",
                $value + $siblingsSum,
                $nearestAncestorValue,
                $nearestAncestorValue - $siblingsSum,
            ));
        }
    }
}
