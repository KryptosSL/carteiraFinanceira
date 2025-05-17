<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    // Outras propriedades e métodos...

    /**
     * Handle unauthenticated exceptions.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Retorna JSON para todas as requisições
        return response()->json([
            'success' => false,
            'message' => 'Não autenticado.',
        ], 401);
    }
}
