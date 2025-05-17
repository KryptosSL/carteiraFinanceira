<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Services\TransacaoService;
use App\Repository\ClienteRepository;
use App\Enums\TiposTransacao;
use App\Enums\StatusTransacao;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
 
use App\Exceptions\BusinessException;


class CarteiraService
{
    protected TransacaoService $transacaoService;
    protected MovimentacaoService $movimentacaoService;
    protected ClienteRepository $clienteRepository;

    public function __construct(
        TransacaoService $transacaoService,
        MovimentacaoService $movimentacaoService,
        ClienteRepository $clienteRepository
    )
    {
        $this->transacaoService = $transacaoService;
        $this->movimentacaoService = $movimentacaoService;
        $this->clienteRepository = $clienteRepository;
    }

    public function saldoCliente($id) {
         return $this->movimentacaoService->obterSaldoCliente($id);
    }

    public function transferirFundos($remetente, $destinarario, $valor) {
        if ($remetente === $destinarario) {
            throw new BusinessException('Não é possível transferir para o mesmo si mesmo.');
        }

        if ($valor <= 0) {
            throw new BusinessException('Valor deve ser maior que zero.');
        }

   
          $remetenteData =  $this->clienteRepository->buscarClienteFromEmail($remetente);
          $remetente = $remetenteData->id;
          $destinararioData = $this->clienteRepository->buscarClienteFromEmail($destinarario);

          if (!$destinararioData) {
                throw new BusinessException('Destinatario não existe.');
          }

          $destinarario = $destinararioData->id;

          $saldo = $this->movimentacaoService->obterSaldoCliente($remetente);
     
         return DB::transaction(function () use ($remetente, $destinarario, $valor) {
            $transacao = $this->transacaoService->registrarTransacao([
                "destinatario" => $destinarario,
                "remetente_id" => $remetente,
                "valor" => $valor,
                "tipo"=> TiposTransacao::ENTRADA,
                "status"=> StatusTransacao::PENDENTE,
                "uid" => Str::uuid()->toString()
            ]);

            $movimentacaoRemetente = $this->movimentacaoService->registrarMovimentacao([
                "cliente_id" => $remetente,
                "valor" => $valor,
                "operacao"=> TiposTransacao::TRANSFERENCIA_SAIDA,
                "transferencia_id" => $transacao["id"]
            ]);

            $movimentacaoDestinatario = $this->movimentacaoService->registrarMovimentacao([
                "cliente_id" => $destinarario,
                "valor" => $valor,
                "operacao"=> TiposTransacao::TRANSFERENCIA_ENTRADA,
                "transferencia_id" => $transacao["id"]
            ]);

            $this->transacaoService->atualizarStatusParaConcluido($transacao["id"]);

            return $transacao;
        });
    }

    public function depositarFundos($clienteId, $valor) {
        return DB::transaction(function () use ($clienteId, $valor) {
            $transacao = $this->transacaoService->registrarTransacao([
                "destinatario" => $clienteId,
                "remetente_id" => $clienteId,
                "valor" => $valor,
                "tipo"=> TiposTransacao::ENTRADA,
                "status"=> StatusTransacao::PENDENTE,
                "uid" => Str::uuid()->toString()
            ]);

            $movimentacao = $this->movimentacaoService->registrarMovimentacao([
                "cliente_id" => $clienteId,
                "valor" => $valor,
                "operacao"=> TiposTransacao::TRANSFERENCIA_ENTRADA,
                "transferencia_id" => $transacao["id"]
            ]);

            $this->transacaoService->atualizarStatusParaConcluido($transacao["id"]);

            return $transacao;
        });
    }

    public function estornarTransacao($id_transacao) {
            $this->transacaoService->estornarTransacao($id_transacao);
    }

 
}
