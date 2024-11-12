<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return [
    'body' => [
        'success' => false,
        'exception' => [
            'message' => 'getMessage'
        ]
    ],
    'default' => [
        'status' => 500
    ],
    UnauthorizedException::class => [
        'status' => 401
    ],
    UnauthorizedHttpException::class => [
        'status' => 401
    ],
    ValidationException::class => [
        'status' => 422
    ],
    NotFoundHttpException::class => [
        'status' => 404
    ],
    AccessDeniedHttpException::class => [
        'status' => 403
    ],
    AuthenticationException::class => [
        'status' => 401
    ],
    'exception' => [
        'status' => 500
    ]
];
