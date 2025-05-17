<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página de Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center px-4 bg-gray-50" >
  <div class="w-full max-w-sm bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Carteira Financeira</h2>
    
    @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email"
          value="{{ old('email') }}" 
          required 
          autofocus
          class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          required 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
        />
      </div>

      <button 
        type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-200"
      >
        Entrar
      </button>
    </form>

    <p id="openModalCriarConta" class="mt-6 text-center text-sm text-gray-600 cursor-pointer">
      Não tem uma conta?
    </p>

  </div>
   <div
    id="modalOverlayCriarConta"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
 
    <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
 
      <button
        id="closeModal2"
        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl"
      >
        &times;
      </button>

      <h2 class="text-2xl font-bold mb-4 text-gray-800">Criar Conta</h2>

      <form id="formularioTransferencia" action="{{ route('criar_conta') }}" method="POST" class="space-y-5">
          @csrf

        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
          <input
            type="text"
            id="nome"
            name="nome"
            
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
           
        </div>
 
        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            type="email"
         
            name="email"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
           
        </div>
      <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
          <input
            type="password"
          
            name="password"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
           
        </div>
              <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Confirme Senha</label>
          <input
            type="password"
            name="password_confirmation"
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

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#openModalCriarConta').click(function () {
        $('#modalOverlayCriarConta').removeClass('hidden');
      });

      $('#closeModal2, #cancelModal2').click(function () {
        $('#modalOverlayCriarConta').addClass('hidden');
      });

    });
  </script>
</body>
</html>
