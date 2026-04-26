<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Registrate | Nominy</title>
</head>
<?php
include_once "components/atom/message.php";
?>
<body  class="bg-gray-100 flex flex-col lg:flex-row justify-center items-center min-h-screen p-4 gap-6">
  <div class="max-w-md mt-6 lg:mt-0 lg:ml-6 p-6 rounded-2xl bg-blue-50 border border-blue-100 shadow-sm self-center">
    <div class="flex items-start gap-4">
      <!-- Icono de información -->
      <div class="bg-blue-500 p-2 rounded-lg shrink-0">
        <svg xmlns="http://w3.org" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-blue-900 font-bold text-sm uppercase tracking-wider">Aviso de Validación</h3>
        <p class="text-blue-800 text-sm leading-relaxed mt-1">
        Para garantizar la seguridad, el departamento de <span class="font-bold">Recursos Humanos</span> validará tu perfil antes de habilitar tu acceso al sistema.
        </p>
      </div>
    </div>
  </div>
  <main class="w-full max-w-md px-4">
    <form action="../app/controllers/userControll.php" class="bg-white rounded-2xl shadow-xl p-10 space-y-6" method="POST">
  <?php
  // Verificamos si en la URL viene la palabra "success"
  if (isset($_GET['success'])) {
    
    // Si dice campo_vacios
    if ($_GET['success'] === 'campo_vacios') {
        echo message("Los campos no pueden estar vacíos", "error");
    }
    
    // Si dice no_coinciden
    if ($_GET['success'] === 'no_coinciden') {
        echo message("Las contraseñas no son iguales", "error");
    }

    // Si dice registrado
    if ($_GET['success'] === 'registrado') {
        echo message("¡Bienvenido! Te has registrado con éxito", "success");
    }
  }
  ?>
      <header class="text-center">
        <h1 class="text-3xl text-orange-600 font-extrabold">Registrate</h1>
        <p class="text-gray-500 text-sm mt-2">Bienvenido de nuevo a NOMINY</p>
      </header>

      <div class="space-y-4">
        <div class="flex flex-col gap-2">
          <label for="dni" class="font-semibold text-gray-700">Docuemento de identidad</label>
          <input 
            type="dni" 
            id="dni"
            name="dni" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all" 
            placeholder="V-24165273"
            required
          >
        </div>
        <!-- Nombre y apellido -->
        <div class="grid grid-cols-2 gap-2">
          <div class="flex flex-col gap-2">
          <label for="name" class="font-semibold text-gray-700">Nombre</label>
          <input 
            type="text" 
            id="name"
            name="name" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all" 
            placeholder="Juan"
            required
          >
          </div>
          <div class="flex flex-col gap-2">
          <label for="lastName" class="font-semibold text-gray-700">Apellido</label>
          <input 
            type="text" 
            id="lastName"
            name="lastName" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all" 
            placeholder="Fernandez"
            required
          >
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label for="userName" class="font-semibold text-gray-700">Email</label>
          <input 
            type="email" 
            id="email"
            name="email" 
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all" 
            placeholder="ejemplo@correo.com"
            required
          >
        </div>

        <div class="grid grid-cols-2 gap-2">

          <div class="flex flex-col gap-2 relative">
            <label for="password" class="font-semibold text-gray-700">Contraseña</label>
            <div class="relative">
              <input 
              type="password" 
              id="password"
              name="pass" 
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all w-full" 
              placeholder="••••••••"
              required
              >

              <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-orange-500 font-bold">
                <span id="toggleText">Mostrar</span>
              </button>
            </div>
          </div>

          <div class="flex flex-col gap-2 relative">
            <label for="password" class="font-semibold text-gray-700">Confirma</label>
            <div class="relative">
              <input 
              type="password" 
              id="passwordConfir"
              name="passConfir" 
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400  transition-all w-full" 
              placeholder="••••••••"
              required
              >
                <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-orange-500 font-bold">
                  <span id="toggleTextConfir">Mostrar</span>
                </button>
            </div>
          </div>
        </div>

      <button class="bg-orange-500 hover:bg-orange-600 active:scale-95 transition-transform p-4 rounded-xl w-full text-white text-lg font-bold shadow-lg shadow-orange-200">
        Crear cuenta
      </button>
      
      <div class="text-center">
        <a href="../index.php" class="text-sm text-orange-600 hover:underline">¿Ya tienes una cuenta?, inicia session.</a>
      </div>
    </form>
  </main>
</body>
<script>
  function togglePass() {
    const input = document.getElementById('password')
    const toggle = document.getElementById("toggleText")

    const inputConfir = document.getElementById("passwordConfir")
    const toggleConfor = document.getElementById("toggleText")

    if(input.type ==="password"){
      input.type = 'text'
      toggle.innerText = 'Ocultar'
      
    } else {
      input.type = 'password';
      toggle.innerText = 'Mostrar';  
    }


    if( inputConfir.type === "password"){
      inputConfir.type = "text"
      toggleConfor.innerText= "Ocultar"
    }else{
        inputConfir.type = "text"
        toggleConfor.innerText= "Ocultar"
    }
  }
</script>
</html>