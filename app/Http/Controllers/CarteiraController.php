<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CarteiraService;
use App\Exceptions\BusinessException;

class CarteiraController extends Controller
{
    protected CarteiraService $carteiraService;
    
    public function __construct(carteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function verSaldo(Request $request) {
        $dados = $request->query();
 
        return $this->carteiraService->saldoCliente(
            $dados['cliente_id']   
        );
    }

    public function depositar(Request $request) {
        $dados = $request->all();

        $this->carteiraService->depositarFundos(
            auth()->id(),
            $dados['valor']
        );

        return redirect()->route('dashboard');
    }

    public function transferir(Request $request) {

        try {
            $dados = $request->all();
            $this->carteiraService->transferirFundos(
                $dados['remetente'],
                $dados['destinatario'],
                $dados['valor']
            );
        } catch (BusinessException $e) {
            return redirect()
            ->route('dashboard')
            ->withErrors($e->getMessage());
        }
   
        return redirect()->route('dashboard');
    }
  
    public function estorno(Request $request) {
         try {
            $dados = $request->all();
            $this->carteiraService->estornarTransacao(
                $dados['transacao_id']
            );
            return redirect()
            ->route('dashboard');

        } catch (BusinessException $e) {
            return redirect()
            ->route('dashboard')
            ->withErrors($e->getMessage());
        }
   
        return redirect()->route('dashboard');
    }

  
}
