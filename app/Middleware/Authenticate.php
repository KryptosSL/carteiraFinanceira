<?php

namespace App\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  ...string  $guards
     * @return mixed
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Identifica se o usuário está autenticado em algum dos guards fornecidos
        if (!$this->authenticateGuards($guards, $request)) {
            $this->unauthenticated($request, $guards);
        }

        return $next($request);
    }

    /**
     * Tenta autenticar usando os guards especificados.
     *
     * @param  array $guards
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function authenticateGuards(array $guards, Request $request): bool
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return true;
            }
        }

        return false;
    }

    /**
     * Override do método unauthenticated para API.
     * Lança exceção retornando JSON, evitando redirecionamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function unauthenticated($request, array $guards): void
    {
        throw new HttpResponseException(
            response()->json([
                'mensagem' => 'Não autenticado.',
                'sucesso' => false,
                'guards' => $guards,
            ], 401)
        );
    }

    /**
     * Override do método redirectTo para impedir redirecionamentos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return null
     */
    protected function redirectTo($request)
    {
        // Nunca redireciona em APIs
        return null;
    }
}