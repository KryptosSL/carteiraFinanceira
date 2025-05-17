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
  
    public function registrarTransacao($data) {

        if (empty($data['destinatario'])) {
            throw new BusinessException('Parametro destinatario necessario.');
        }

        if (empty($data['remetente_id'])) {
            throw new BusinessException('Parametro remetente_id operacao necessario.');
        }

        if (empty($data['valor'])) {
            throw new BusinessException('Parametro valor operacao necessario.');
        }

        if (empty($data['tipo'])) {
            throw new BusinessException('Parametro tipo operacao necessario.');
        }

        if (empty($data['status'])) {
            throw new BusinessException('Parametro status operacao necessario.');
        }

        if (empty($data['uid'])) {
            throw new BusinessException('Parametro uid operacao necessario.');
        }

        return $this->transacaoRepository->criar($data);
    }

    public function atualizarStatusParaConcluido($id) {
        
        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro.');
        }

        return $this->transacaoRepository->atualizar($id,[
            "status" => StatusTransacao::CONCLUIDA
        ]);
    }

    public function estornarTransacao($id) {
        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro.');
        }

        return $this->transacaoRepository->atualizar($id,[
            "status" => StatusTransacao::ESTORNO
        ]);
    }
}
