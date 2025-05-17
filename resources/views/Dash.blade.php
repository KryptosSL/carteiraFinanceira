<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carteira Financial</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

 
  <div class="flex justify-between items-center p-6">
    <div>
      <h1 class="text-2xl font-bold">Carteira Financeira</h1>
      <p class="text-gray-500">Controle suas finanças</p>
    </div>
    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold cursor-pointer">
     
        <a   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Sair
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

  </div>

     
    @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            {{ $error }}
          @endforeach
        </ul>
      </div>
    @endif
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-6">
 
    <div class="bg-gradient-to-r from-purple-400 to-purple-600 text-white p-6 rounded-xl shadow">
      <p class="text-sm">Saldo Total</p>
      <p class="text-3xl font-bold mt-1"> {{ $saldo }}</p>
      <div class="mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 11h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
        </svg>
      </div>
    </div>

     
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
      <div>
        <p class="text-gray-500">Entradas</p>
        <p class="text-2xl font-bold mt-1">{{ $entrada }}</p>
      </div>
       
    </div>
 
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
      <div>
        <p class="text-gray-500">Saídas</p>
        <p class="text-2xl font-bold mt-1">{{ $saida }}</p>
      </div>
     
    </div>
  </div>

  <div class="flex gap-4 px-6 mt-6">
    <button id="openModalTransferencia" class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
      </svg>
      Transferir
    </button>

    <button id="openModalDeposito" class="flex items-center gap-2 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8m13-5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7z" />
      </svg>
      Depositar
    </button>
  </div>

 
  <div class="px-6 mt-8">
    <h2 class="text-xl font-semibold mb-4">Transações Recentes</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-left bg-white rounded-xl shadow">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="px-6 py-3">Data</th>
             
            <th class="px-6 py-3">Valor</th>
            <th class="px-6 py-3">Tipo</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3"> </th>
          </tr>
        </thead>
        <tbody>
          
        @foreach ($movimentacoes as $transacao)
          @php
            $isEntrada = strtolower($transacao->operacao) === 'transferencia_entrada';
            $isSaida = strtolower($transacao->operacao) === 'transferencia_saida';
            $isEstorno = strtolower($transacao->transacoes_status) === 'estorno';
            $dataFormatada = date('d/m/Y H:i', strtotime($transacao->created_at));
          @endphp

          <tr class="border-t">
            <td class="px-6 py-4">{{ $dataFormatada }}</td>
            <td class="px-6 py-4 font-semibold {{ $isEntrada ? 'text-green-600' : 'text-red-600' }}">
              {{ 'R$ ' . number_format((float) $transacao->valor, 2, ',', '.') }}
            </td>
            <td class="px-6 py-4">
              <span class="bg-{{ $isEntrada ? 'green' : 'red' }}-100 px-2 py-1 rounded-full text-sm {{ $isEntrada ? 'text-green-700' : 'text-red-700' }}">
                {{ $transacao->operacao }}
              </span>
            </td>
            <td class="px-6 py-4">
              <span class="bg-{{ $isEstorno ? 'red' : 'green' }}-100 px-2 py-1 rounded-full text-sm {{ !$isEstorno ? 'text-green-700' : 'text-red-700' }}">
                {{ $transacao->transacoes_status }}
              </span>
            </td>
            <td class="px-6 py-4">
            @if($isEntrada && !$isEstorno)
              <form action="{{ route('estorno') }}" method="POST" style="display:inline">
                @csrf
                <input type="hidden" name="transacao_id" value="{{ $transacao->transferencia_id }}" />
                <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-3 py-1 rounded">
                  Estornar
                </button>
              </form>
            @endif
            </td>
          </tr>
        @endforeach


 
        </tbody>
      </table>
    </div>
  </div>
 <div
    id="modalOverlayDeposito"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
 
    <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
 
      <button
        id="closeModal"
        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl"
      >
        &times;
      </button>

      <h2 class="text-2xl font-bold mb-4 text-gray-800">Realizar deposito</h2>

  
      <form id="formulario" action="{{ route('depositar') }}" method="POST" class="space-y-5">
          @csrf

        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
          <input
            type="text"
     
             id="quantidade_deposito"
            name="valor"
            min="0"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>


        <div class="flex justify-end gap-3">
          <button
            type="button"
            id="cancelModal"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
          >
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>

   <div
    id="modalOverlayTransferencia"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
 
    <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
 
      <button
        id="closeModal2"
        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl"
      >
        &times;
      </button>

      <h2 class="text-2xl font-bold mb-4 text-gray-800">Realizar Transferência</h2>

      <form id="formularioTransferencia" action="{{ route('transferir') }}" method="POST" class="space-y-5">
          @csrf

        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Destinatario</label>
          <input
            type="email"
            id="nome"
            name="destinatario"
            
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
          <input
            type="hidden"
            id="nome"
            name="remetente"
            value="{{ $email }}"
          />
        </div>
        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
          <input
            type="text"
            id="quantidade_transferencia"
            name="valor"
            min="0"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>


        <div class="flex justify-end gap-3">
          <button
            type="button"
            id="cancelModal2"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
          >
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>



  <script>
    $(document).ready(function () {
      $('#openModalDeposito').click(function () {
        $('#modalOverlayDeposito').removeClass('hidden');
      });

      $('#openModalTransferencia').click(function () {
        $('#modalOverlayTransferencia').removeClass('hidden');
      });

 

      $('#closeModal2, #cancelModal2').click(function () {
        $('#modalOverlayTransferencia').addClass('hidden');
      });



      $('#closeModal, #cancelModal').click(function () {
        $('#modalOverlayDeposito').addClass('hidden');
      });

      
       
    });

   
  </script>

</body>
</html>
