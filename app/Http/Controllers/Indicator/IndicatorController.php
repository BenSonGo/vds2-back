<?php

namespace App\Http\Controllers\Indicator;

use App\Exceptions\RequestForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Indicator\CreateIndicatorRequest;
use App\Http\Requests\Indicator\UpdateIndicatorRequest;
use App\Http\Resources\Indicator\IndicatorCollection;
use App\Http\Resources\Indicator\IndicatorResource;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\Indicator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class IndicatorController extends Controller
{
    public function collection(): IndicatorCollection
    {
        /** @var User $user */
        $user = Auth::user();
        return new IndicatorCollection($user->companyIndicators);
    }

    public function get(Indicator $indicator): IndicatorResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyIndicators->doesntContain($indicator->id)) {
            throw new RequestForbiddenException('Indicator isn\'t assigned to user');
        }

        return new IndicatorResource($indicator);
    }

    public function create(CreateIndicatorRequest $request): IndicatorResource
    {
        /** @var User $user */
        $user = Auth::user();

        return new IndicatorResource(
            Indicator::create([
                'user_id' => $user->id,
                'name' => $request->get('name'),
            ])
        );
    }

    public function update(UpdateIndicatorRequest $request, Indicator $indicator): IndicatorResource
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyIndicators->doesntContain($indicator->id)) {
            throw new RequestForbiddenException('Indicator isn\'t assigned to user');
        }

        return new IndicatorResource(
            $indicator->update($request->validated())
        );
    }

    public function delete(Indicator $indicator): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyIndicators->doesntContain($indicator->id)) {
            throw new RequestForbiddenException('Indicator isn\'t assigned to user');
        }

        $indicator->delete();
        return new SuccessJsonResponse();
    }
}
