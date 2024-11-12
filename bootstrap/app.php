<?php

use App\Http\Responses\ApiExceptionsJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;

return Application::configure(basePath:dirname(__DIR__))
    ->withRouting(
        web:__DIR__ . '/../routes/web.php',
        api:__DIR__ . '/../routes/api.php',
        commands:__DIR__ . '/../routes/console.php',
        health:'/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        if (request()->is('api/*')) {
            $config = config('api-responses');
            if (request()->is('api/*')) {
                $exceptions = $exceptions->shouldRenderJsonWhen(fn() => true);

                $exceptions->render(function (Throwable $e, Request|HttpRequest $request = null) use ($config) {
                    report($e);

                    try {
                        return new ApiExceptionsJsonResponse($e, $config[get_class($e)] ?? $config['default'],
                            $config['body']);
                    } catch (Throwable $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ], 500);
                    }
                });
            }
        }
    })->create();
