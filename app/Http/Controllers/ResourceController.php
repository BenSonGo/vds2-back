<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestForbiddenException;
use App\Http\Requests\Resource\CreateResourceRequest;
use App\Http\Requests\Resource\UpdateResourceRequest;
use App\Http\Resources\Resource\ResourceResource;
use App\Http\Resources\Resource\ResourceApiCollection;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function collection(): ResourceApiCollection
    {
        /** @var User $user */
        $user = Auth::user();
        return new ResourceApiCollection($user->companyResources);
    }

    public function get(Resource $resource): ResourceResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyResources->doesntContain($resource->id)) {
            throw new RequestForbiddenException('Resource isn\'t assigned to user');
        }

        return new ResourceResource($resource);
    }

    public function create(CreateResourceRequest $request): ResourceResource
    {
        /** @var User $user */
        $user = Auth::user();

        return new ResourceResource(
            Resource::create([
                'user_id' => $user->getKey(),
                'name' => $request->get('name'),
            ])
        );
    }

    public function update(UpdateResourceRequest $request, Resource $resource): ResourceResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyResources->doesntContain($resource->id)) {
            throw new RequestForbiddenException('Resource isn\'t assigned to user');
        }

        return new ResourceResource(
            $resource->update($request->validated())
        );
    }

    public function delete(Resource $resource): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyResources->doesntContain($resource->id)) {
            throw new RequestForbiddenException('Resource isn\'t assigned to user');
        }

        $resource->delete();
        return new SuccessJsonResponse();
    }
}
