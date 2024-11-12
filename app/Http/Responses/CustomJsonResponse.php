<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class CustomJsonResponse extends JsonResponse
{
    public function __construct(
        array $body = [],
        int   $status = 200,
        array $headers = [],
        int   $options = 0
    ) {
        parent::__construct($body, $status, $headers, $options | JSON_UNESCAPED_UNICODE);
    }
}
