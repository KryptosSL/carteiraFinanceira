<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\MovimentacaoRepository;
use App\Exceptions\BusinessException;

class MovimentacaoService 
{
    protected MovimentacaoRepository $movimentacaoRepository;
    
    public function __construct(MovimentacaoRepository $movimentacaoRepository) {
        $this->movimentacaoRepository = $movimentacaoRepository;
    }

    public function registrarMovimentacao(array $data) {
        if (empty($data['cliente_id']) || filter_var($data['cliente_id'], FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro cliente_id necessario e deve ser inteiro.');
        }

        if (empty($data['valor']) || filter_var($data['valor'], FILTER_VALIDATE_FLOAT) === false) {
            throw new BusinessException('Parametro valor necessario e deve ser decimal.');
        }

        if (empty($data['operacao'])) {
            throw new BusinessException('Parametro operacao necessario e deve ser string.');
        }
        
        if (empty($data['transferencia_id']) || filter_var($data['transferencia_id'], FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro transferencia_id necessario e deve ser inteiro.');
        }

        return $this->movimentacaoRepository->criar($data);
    }

    public function obterSaldoCliente($id) {

        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro.');
        }

        $this->movimentacaoRepository->buscarSaldoEntradaCliente($id);

        $saldoEntrada = $this->movimentacaoRepository->buscarSaldoEntradaCliente($id);
        $saldoSaida = $this->movimentacaoRepository->buscarSaldoSaidaCliente($id);

        return $saldoEntrada - $saldoSaida;
    }

     public function obterEntradaSaida($id) {
 
        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro.');
        }

        $saldoEntrada = $this->movimentacaoRepository->buscarSaldoEntradaCliente($id);
        $saldoSaida = $this->movimentacaoRepository->buscarSaldoSaidaCliente($id);

        return [
            "entrada" => $saldoEntrada,
            "saida" => $saldoSaida
        ];
    }

    public function listarMovimentacaoCliente(int $id) {

        if (empty($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
            throw new BusinessException('Parametro id necessario e deve ser inteiro.');
        }
        return $this->movimentacaoRepository->buscarTodasMovimentacoesCliente($id);
    }
    
}
