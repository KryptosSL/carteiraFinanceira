<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CarteiraService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'valor' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $dados = $validator->validated();

        try {
            $this->carteiraService->depositarFundos(
                auth()->id(),
                $dados['valor']
            );
        } catch (BusinessException $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }

        return redirect()->route('dashboard');
    }

    public function transferir(Request $request) {

        $validator = Validator::make($request->all(), [
            'remetente' => ['required', 'email', 'exists:users,email'],
            'destinatario' => ['required', 'email', 'exists:users,email', 'different:remetente'],
            'valor' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $dados = $validator->validated();

        try {
            $this->carteiraService->transferirFundos(
                $dados['remetente'],
                $dados['destinatario'],
                $dados['valor']
            );
            return redirect()->route('dashboard');
        } catch (BusinessException $e) {
           return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }

    }
  
    public function estorno(Request $request) {

        $validator = Validator::make($request->all(), [
            'transacao_id' => ['required', 'integer', 'min:0', 'exists:transacoes,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $dados = $validator->validated();

         try {
            $dados = $request->all();
            $this->carteiraService->estornarTransacao(
                $dados['transacao_id']
            );
            return redirect()
            ->route('dashboard');

        } catch (BusinessException $e) {
           return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }
}
