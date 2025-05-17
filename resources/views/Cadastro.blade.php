<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página de Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
 
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
      
    @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  <div class="w-full max-w-sm bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Bem-vindo de volta 👋</h2>
    
    <form action="#" method="POST" class="space-y-5">
        @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          required 
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

      <div class="flex items-center justify-between">
        <label class="flex items-center space-x-2 text-sm text-gray-600">
          <input type="checkbox" class="form-checkbox text-indigo-600" />
          <span>Lembrar de mim</span>
        </label>
        <a href="#" class="text-sm text-indigo-600 hover:underline">Esqueceu a senha?</a>
      </div>

      <button 
        type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition duration-200"
      >
        Entrar
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Não tem uma conta? 
      <a href="#" class="text-indigo-600 hover:underline">Cadastre-se</a>
    </p>
  </div>
</body>
</html>
