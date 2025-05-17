<?php

namespace App\Repository;

use App\Models\Cliente;

class ClienteRepository
{
    protected Cliente $model;

    public function buscarClientedoUser($userId) {
        return Cliente::where('user_id', $userId)->get();
    }

    public function buscarClienteFromEmail($email) {
        return Cliente::where('email', $email)->first();
    }

    public function criar($data) {
        return Cliente::create([
            'user_id' => $data['user_id'],
            'nome' => $data['nome'],
            'email' => $data['email']
        ]);
    }

    public function atualizar($data) {
         
    }

}
