<?php

namespace App\Http\Controllers\Actions\CompanySubunitWorkDaysByMonth;

use App\DataTransferObjects\CreateCompanySubunitWorkDaysByMonthDTO;
use App\Http\Requests\CompanySubunitWorkDaysByMonth\CreateCompanySubunitWorkDaysByMonthRequest;
use App\Http\Resources\Company\Subunit\WorkDaysByMonth\CompanySubunitWorkDaysByMonthResource;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanySubunitWorkDaysByMonth\CreateCompanySubunitWorkDaysByMonthService;
use Illuminate\Support\Facades\Auth;

final class CreateCompanySubunitWorkDaysByMonth
{
    public function __invoke(
        CreateCompanySubunitWorkDaysByMonthRequest $request,
        CreateCompanySubunitWorkDaysByMonthService $createWorkDaysService
    ): CompanySubunitWorkDaysByMonthResource {
        /**
         * @var User $user
         * @var Company $company
         */

        $user = Auth::user();

        if (!$user) {
            throw new \RuntimeException("Forbidden");
        }

        $company = Company::findOrFail($request->get('company_id'));
        $companySubunitId = $request->get('company_subunit_id');

        if ($user->doesntHaveCompany($company->id)) {
            throw new \RuntimeException("Company is not assigned to user");
        }

        if ($companySubunitId && $company->subunits->doesntContain($companySubunitId)) {
            throw new \RuntimeException("Subunit is not assigned to company");
        }

        $workDaysByMonth = $createWorkDaysService(
            CreateCompanySubunitWorkDaysByMonthDTO::fromRequest($request)
        );

        return new CompanySubunitWorkDaysByMonthResource($workDaysByMonth);
    }
}
