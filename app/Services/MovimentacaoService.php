<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repository\MovimentacaoRepository;

class MovimentacaoService 
{
    protected MovimentacaoRepository $movimentacaoRepository;
    
    public function __construct(MovimentacaoRepository $movimentacaoRepository) {
        $this->movimentacaoRepository = $movimentacaoRepository;
    }
    
    public function registrarMovimentacao(array $data) {
        return $this->movimentacaoRepository->criar($data);
    }

    public function obterSaldoCliente($id) {
 
        $saldoEntrada = $this->movimentacaoRepository->buscarSaldoEntradaCliente($id);
        $saldoSaida = $this->movimentacaoRepository->buscarSaldoSaidaCliente($id);

        return $saldoEntrada - $saldoSaida;
    }

     public function obterEntradaSaida($id) {
 
        $saldoEntrada = $this->movimentacaoRepository->buscarSaldoEntradaCliente($id);
        $saldoSaida = $this->movimentacaoRepository->buscarSaldoSaidaCliente($id);

        return [
            "entrada" => $saldoEntrada,
            "saida" => $saldoSaida
        ];
    }

    public function listarMovimentacaoCliente($id) {
        return $this->movimentacaoRepository->buscarTodasMovimentacoesCliente($id);
    }
    
}
