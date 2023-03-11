<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestForbiddenException;
use App\Http\Requests\Activity\CreateActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Http\Resources\Activity\ActivityCollection;
use App\Http\Resources\Activity\ActivityResource;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function collection(): ActivityCollection
    {
        /** @var User $user */
        $user = Auth::user();
        return new ActivityCollection($user->companyActivities);
    }

    public function get(Activity $activity): ActivityResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyActivities->doesntContain($activity->id)) {
            throw new RequestForbiddenException('Activity isn\'t assigned to user');
        }

        return new ActivityResource($activity);
    }

    public function create(CreateActivityRequest $request): ActivityResource
    {
        /** @var User $user */
        $user = Auth::user();
        $resourceId = $request->get('resource_id');

        if ($user->companyResources->doesntContain($resourceId)) {
            throw new RequestForbiddenException('Resource isn\'t assigned to user');
        }

        return new ActivityResource(
            Activity::create([
                'name' => $request->get('name'),
                'resource_id' => $resourceId,
                'expected_effect' => $request->get('expected_effect'),
                'money_spent' => $request->get('money_spent'),
                'funding_source' => $request->get('funding_source'),
                'implemented_date' => $request->get('implemented_date'),
            ])
        );
    }

    public function update(UpdateActivityRequest $request, Activity $activity): ActivityResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyActivities->doesntContain($activity->id)) {
            throw new RequestForbiddenException('Activity isn\'t assigned to user');
        }

        $activity->update($request->validated());

        return new ActivityResource($activity);
    }

    public function delete(Activity $activity): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyActivities->doesntContain($activity->id)) {
            throw new RequestForbiddenException('Activity isn\'t assigned to user');
        }

        $activity->delete();
        return new SuccessJsonResponse();
    }
}
