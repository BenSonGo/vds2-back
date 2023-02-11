<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\LoginResource;
use App\Http\Responses\SuccessJsonResponse;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): LoginResource
    {
        $user = User::query()->where('email', $request->get('email'))->first();

        if(!$user || !Hash::check($request->get('password'), $user->password)) {
            throw new AuthenticationException('Bad credentials.');
        }

        return new LoginResource($user, $user->createToken($user->name));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): SuccessJsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return new SuccessJsonResponse();
    }
}
