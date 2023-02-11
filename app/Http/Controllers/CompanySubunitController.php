<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestForbiddenException;
use App\Http\Requests\Company\Subunit\CreateCompanySubnitRequest;
use App\Http\Requests\Company\Subunit\GetCompanySubunitCollectionRequest;
use App\Http\Requests\Company\Subunit\UpdateCompanySubnitRequest;
use App\Http\Resources\Company\Subunit\CompanySubunitCollection;
use App\Http\Resources\Company\Subunit\CompanySubunitResource;
use App\Http\Resources\Company\Subunit\CompanySubunitTreeCollection;
use App\Http\Resources\Company\Subunit\CompanySubunitTreeResource;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanySubunitController extends Controller
{
    public function collection(GetCompanySubunitCollectionRequest $request): CompanySubunitCollection
    {
        /**
         * @var Company $company
         * @var User $user
         */
        $company = Company::findOrFail($request->get('company_id'));
        $user = Auth::user();

        if ($user->doesntHaveCompany($company->id)) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        return new CompanySubunitCollection($company->subunits);
    }

    public function collectionTree(GetCompanySubunitCollectionRequest $request): CompanySubunitTreeCollection
    {
        /**
         * @var Company $company
         * @var User $user
         */
        $company = Company::findOrFail($request->get('company_id'));
        $user = Auth::user();

        if ($user->doesntHaveCompany($company->id)) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        return new CompanySubunitTreeCollection($company->subunits->toTree());
    }

    public function get(CompanySubunit $subunit): CompanySubunitTreeResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($subunit->company->id)) {
            throw new RequestForbiddenException('Company subunit isn\'t assigned to user');
        }

        return new CompanySubunitTreeResource($subunit);
    }

    public function create(CreateCompanySubnitRequest $request): CompanySubunitResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($request->get('company_id'))) {
            throw new RequestForbiddenException('Company isn\'t assigned to user');
        }

        return new CompanySubunitResource(
            CompanySubunit::create($request->validated())
        );
    }

    public function update(UpdateCompanySubnitRequest $request, CompanySubunit $subunit): CompanySubunitResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($subunit->company->id)) {
            throw new RequestForbiddenException('Company subunit isn\'t assigned to user');
        }

        return new CompanySubunitResource(
            $subunit->update($request->validated())
        );
    }

    public function delete(CompanySubunit $subunit): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->doesntHaveCompany($subunit->company->id)) {
            throw new RequestForbiddenException('Company subunit isn\'t assigned to user');
        }

        $subunit->delete();
        return new SuccessJsonResponse();
    }
}
