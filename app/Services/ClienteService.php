<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\ClienteRepository;

class ClienteService 
{
    protected ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository) {
        $this->clienteRepository = $clienteRepository;
    }
    
    public function criaCliente(array $data) {
        return $this->clienteRepository->criar($data);
    }

    public function buscarClienteFromUSer($id) {
        return $this->clienteRepository->buscarClientedoUser($id);
    }
    
}
