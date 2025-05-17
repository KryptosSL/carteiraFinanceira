<?php

namespace App\Repository;

use App\Models\Movimentacoes;
use App\Enums\TiposTransacao;
use App\Enums\StatusTransacao;
use Illuminate\Support\Facades\DB;

class MovimentacaoRepository
{
    public function criar($data) {
        return Movimentacoes::create($data);
    }
 
    public function buscarSaldoSaidaCliente($id) {
        return DB::table('movimentacoes')
            ->join('transacoes', function ($join) {
                $join->on('transacoes.id', '=', 'movimentacoes.transferencia_id')
                    ->where('transacoes.status', '=', StatusTransacao::CONCLUIDA);
            })
            ->where('movimentacoes.operacao', TiposTransacao::TRANSFERENCIA_SAIDA)
            ->where('movimentacoes.cliente_id', $id)  
            ->sum('movimentacoes.valor');
    }

    public function buscarSaldoEntradaCliente($id) {
        return DB::table('movimentacoes')
            ->join('transacoes', function ($join) {
                $join->on('transacoes.id', '=', 'movimentacoes.transferencia_id')
                    ->where('transacoes.status', '=', StatusTransacao::CONCLUIDA);
            })
            ->where('movimentacoes.operacao', TiposTransacao::TRANSFERENCIA_ENTRADA)
            ->where('movimentacoes.cliente_id', $id) 
            ->sum('movimentacoes.valor');
    }

    public function buscarTodasMovimentacoesCliente($id) {
        return DB::table('movimentacoes')
            ->join('transacoes', 'movimentacoes.transferencia_id', '=', 'transacoes.id')
            ->where('movimentacoes.cliente_id', $id)
            ->select('movimentacoes.*', 'transacoes.status as transacoes_status')
            ->get();
    }
}
