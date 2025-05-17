<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\ClienteRepository;
use App\Exceptions\BusinessException;

class ClienteService 
{
    protected ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository) {
        $this->clienteRepository = $clienteRepository;
    }
    
    public function criaCliente(array $data) {
       
        if (!array_key_exists('user_id', $data) || !$data['user_id']) {
            throw new BusinessException('Parametro id do usuario necessario.');
        }

        if (!array_key_exists('nome', $data) || !$data['nome']) {
            throw new BusinessException('Parametro nome necessario.');
        }

        if (!array_key_exists('email', $data) || !$data['email']) {
            throw new BusinessException('Parametro email necessario.');
        }

        return $this->clienteRepository->criar($data);
    }

    public function buscarClienteFromUSer(int $id) {
        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro');
        }
        return $this->clienteRepository->buscarClientedoUser($id);
    }
    
}
