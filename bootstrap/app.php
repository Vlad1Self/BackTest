<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Добавляем middleware для API авторизации
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Для работы с фронтендом (например, Vue)
            'throttle:api', // Ограничение числа запросов
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Связывание маршрутов
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Обработка исключений для авторизации
        $exceptions->map(\Illuminate\Auth\AuthenticationException::class, function ($exception, $request) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        });
    })->create();
