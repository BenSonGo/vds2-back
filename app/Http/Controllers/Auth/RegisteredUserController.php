<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\RegisterResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function store(Request $request): RegisterResource
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'name' => ['string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        /** @var User $user */
        $user = User::create([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'password' => Hash::make($request->get('password')),
        ]);


//        event(new Registered($user));
        Auth::setUser($user);

        return new RegisterResource($user, $user->createToken($user->name));
    }
}
