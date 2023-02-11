<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Success\SuccessResource;
use Laravel\Sanctum\NewAccessToken;

final class LoginResource extends SuccessResource
{
    public function __construct($resource, private NewAccessToken $token)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'token' => $this->token->plainTextToken,
        ];
    }
}
