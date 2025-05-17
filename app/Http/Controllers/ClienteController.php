<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;

 
use App\Services\UserService;
use App\Services\ClienteService;

class ClienteController extends Controller
{
    protected UserService $userService;
    protected ClienteService $clienteService;

    public function __construct(UserService $userService, ClienteService $clienteService) {
        $this->userService = $userService;
        $this->clienteService = $clienteService;
    }

    public function criaUsuario(ClienteRequest $request) {

        $dados = $request->validated();
   
        $usuario = $this->userService->novoUsuario($dados);
        $dados["user_id"] = $usuario['id'];
        $cliente = $this->clienteService->criaCliente($dados);
        
        return redirect()->route('login');
    }
}
