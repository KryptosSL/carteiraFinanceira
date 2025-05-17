<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
      ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
      /*  $exceptions->renderable(function (BusinessException $e, $request) {
            return response()->json(["teste" => "1111"], 400);
        });

        $exceptions->renderable(function (Throwable $e, $request) {
            return response()->json([
                "mensagem" => "Erro insperado.",
                "sucesso" => false
            ], 500);
        });  */

    })
 
    ->create();
