<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Middleware\Authenticate;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});


//Route::post('/login', [LoginController::class, 'efetuarLogin']);
/*
Route::post('/cliente/criar', [ClienteController::class, 'criaUsuario']);

Route::get('/carteira/saldo', [CarteiraController::class, 'verSaldo']);
Route::post('/carteira/transferir', [CarteiraController::class, 'transferir']);
Route::post('/carteira/estorno', [CarteiraController::class, 'estorno']);


 


Route::middleware([Authenticate::class])->get('/', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});*/

