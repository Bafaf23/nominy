<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Inicio | Nominy</title>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
  <main class="w-full max-w-md px-4">
    <form action="app/controllers/userControll.php" class="bg-white rounded-2xl shadow-xl p-10 space-y-6" method="post">
      <header class="text-center">
        <h1 class="text-3xl text-orange-600 font-extrabold">Inicia sesión</h1>
        <p class="text-gray-500 text-sm mt-2">Bienvenido de nuevo a NOMINY</p>
      </header>

      <div class="space-y-4">
        <div class="flex flex-col gap-2">
          <label for="userName" class="font-semibold text-gray-700">Usuario</label>
          <input 
            type="email" 
            id="userName"
            name="userName" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all" 
            placeholder="ejemplo@correo.com"
            required
          >
        </div>
        <div class="flex flex-col gap-2 relative">
          <label for="password" class="font-semibold text-gray-700">Contraseña</label>
          <div class="relative">
          <input 
            type="password" 
            id="password"
            name="password" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all w-full" 
            placeholder="••••••••"
            required
          >
          <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-orange-500 font-bold">
            <span id="toggleText">Mostrar</span>
          </button>
        </div>
      </div>
      <input type="hidden" name="action" value="login">
      <button class="bg-orange-500 hover:bg-orange-600 active:scale-95 transition-transform p-4 rounded-xl w-full text-white text-lg font-bold shadow-lg shadow-orange-200">
        Entrar
      </button>
      
      <div class="text-center">
        <a href="views/register.php" class="text-sm text-orange-600 hover:underline">Registrate</a>
      </div>
    </form>
  </main>
</body>
<script>
  function togglePass() {
    const input = document.getElementById('password')
    const toggle = document.getElementById("toggleText")

    if(input.type ==="password"){
      input.type = 'text'
      toggle.innerText = 'Ocultar'
    } else {
      input.type = 'password';
      toggle.innerText = 'Mostrar';
    }
  }
</script>
</html>