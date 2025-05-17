<?php

namespace App\Repository;

use App\Models\Transacao;

class TransacaoRepository
{
    public function criar($data) {
        return Transacao::create($data);
    }

    public function atualizar(int $id, array $data) {
        $transacao = Transacao::findOrFail($id);
        $transacao->update($data);
        return $transacao;
    }

    public function buscarPorId(int $id) {
        $transacao = Transacao::findOrFail($id);
        return Transacao::findOrFail($id); 
    }
    
    public function buscarTransacoesPorClienteId(int $clienteId) {
        return Transacao::where('cliente_id', $clienteId)->get();
    }
}
