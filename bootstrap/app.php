<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                $status = 500;
                $message = 'Server Error';
                if ($e instanceof ModelNotFoundException) {
                    $status = 404;
                    $message = 'Resource not found';
                } elseif ($e instanceof AuthorizationException) {
                    $status = 403;
                    $message = 'Forbidden';
                } elseif ($e instanceof ValidationException) {
                    $status = 422;
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $e->errors()
                        ],
                        422
                    );
                }
                return response()->json(
                    [
                        'success' => false,
                        'message' => $message,
                    ],
                    $status,
                );
            }
        });
    })->create();
