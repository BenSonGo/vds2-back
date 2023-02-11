<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class SuccessJsonResponse extends JsonResponse
{
    public function __construct($data = null, $status = 200, $headers = [], $options = 0, $json = false)
    {
        if (null === $data) {
            $data = [];
        }

        $data['success'] = 1;

        parent::__construct($data, $status, $headers, $options, $json);
    }
}
