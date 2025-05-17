<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Exceptions\BusinessException;


class UserService
{
    public function novoUsuario(array $data) 
    {
        if (empty($data['nome']) || !is_string($data['nome'])) {
            throw new BusinessException('Parametro nome necessario e deve ser string.');
        }

        if (empty($data['email']) || !is_string($data['email'])) {
            throw new BusinessException('Parametro email necessario e deve ser string.');
        }

        if (empty($data['password']) || !is_string($data['password'])) {
            throw new BusinessException('Parametro password necessario e deve ser string.');
        }

        return User::create([
            'name' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
