<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\TransacaoRepository;
use App\Enums\StatusTransacao;
use App\Exceptions\BusinessException;

class TransacaoService 
{   
    protected TransacaoRepository $transacaoRepository;

    public function  __construct(TransacaoRepository $transacaoRepository) {
        $this->transacaoRepository = $transacaoRepository;
    }

    public function registrarTransacao($dados) {
        return $this->transacaoRepository->criar($dados);
    }

    public function atualizarStatusParaConcluido($id) {
        return $this->transacaoRepository->atualizar($id,[
            "status" => StatusTransacao::CONCLUIDA
        ]);
    }

    public function estornarTransacao($id) {
        return $this->transacaoRepository->atualizar($id,[
            "status" => StatusTransacao::ESTORNO
        ]);
    }
}
