<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\ClienteController;


Route::get('/pagina', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/cliente/criar', [ClienteController::class, 'criaUsuario'])->name('criar_conta');
Route::post('/carteira/depositar', [CarteiraController::class, 'depositar'])->middleware('auth')->name('depositar');
Route::post('/carteira/transferir', [CarteiraController::class, 'transferir'])->middleware('auth')->name('transferir');
Route::post('/carteira/estorno', [CarteiraController::class, 'estorno'])->middleware('auth')->name('estorno');


Route::get('/dashboard', [DashController::class, 'index'])->middleware('auth')->name('dashboard');



 