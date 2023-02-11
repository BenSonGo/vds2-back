<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Success\SuccessResource;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

final class RegisterResource extends SuccessResource
{
    public function __construct($resource, private NewAccessToken $token)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $this->token->plainTextToken,
        ];
    }
}
