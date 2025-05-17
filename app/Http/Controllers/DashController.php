<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use  App\Services\ClienteService;
use  App\Services\MovimentacaoService;
use  App\Exceptions\BusinessException;

class DashController extends Controller
{

    protected ClienteService $clienteService;
    protected MovimentacaoService $movimentacaoService;

    public function __construct(ClienteService $clienteService, MovimentacaoService $movimentacaoService) {
        $this->clienteService = $clienteService;
        $this->movimentacaoService = $movimentacaoService;
    }

    public function index()
    {   
        if (auth()->check()) {

     
            $cliente = $this->clienteService->buscarClienteFromUSer(auth()->id());
            $arrEntradaSaida = $this->movimentacaoService->obterEntradaSaida($cliente[0]->id);
            $saldo = $this->movimentacaoService->obterSaldoCliente($cliente[0]->id) ?? 0;
            $movimentacoes = $this->movimentacaoService->listarMovimentacaoCliente($cliente[0]->id);

            return view('dash', [
                "email" => $cliente[0]->email,
                "saldo" => 'R$ ' . number_format($saldo, 2, ',', '.'),
                "entrada" => 'R$ ' . number_format($arrEntradaSaida['entrada'], 2, ',', '.'),
                "saida" => 'R$ ' . number_format($arrEntradaSaida['saida'], 2, ',', '.'),
                "movimentacoes" => $movimentacoes
            ]);
        

        } else {
            return redirect()->route('login');
        }
    }
}
