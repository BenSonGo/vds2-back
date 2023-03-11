<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestForbiddenException;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function collection(): CompanyCollection|int
    {
        /** @var User $user */
        $user = Auth::user();
        return new CompanyCollection($user->companies);
    }

    public function get(Company $company): CompanyResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($company->id)) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        return new CompanyResource($company);
    }

    public function create(CreateCompanyRequest $request): CompanyResource
    {
        $company = Company::create($request->validated());

        /** @var User $user */
        $user = Auth::user();

        $user->companies()->save($company);

        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company): CompanyResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($company->id)) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function delete(Company $company): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($company->id)) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        $company->delete();
        return new SuccessJsonResponse();
    }
}
