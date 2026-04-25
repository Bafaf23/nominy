<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=no_autorizado");
    exit;
}

// 2. Aquí podrías consultar a la BD para traer el nombre real del usuario usando su ID
// Por ahora usaremos variables de relleno simulando que vienen de la BD
$nombreUsuario = "Bryant"; 
$inicial = substr($nombreUsuario, 0, 1);
$rolUsuario = "Desarrollador";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- Fontawesone -->
  <script src="https://kit.fontawesome.com/a74559d35e.js" crossorigin="anonymous"></script>
  <title>Panel - Inicio</title>
</head>
<body class="bg-gray-100 h-screen flex p-4 gap-4">
  
  <!-- BARRA LATERAL (ASIDE) -->
  <aside class="w-72 bg-white rounded-2xl shadow-xl p-6 flex flex-col justify-between">
    <div>
      <!-- Perfil -->
      <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
        <div class="bg-orange-100 w-12 h-12 rounded-full flex justify-center items-center text-orange-600 font-bold text-xl">
          <span><?php echo $inicial; ?></span>
        </div>
        <div>
            <h1 class="text-lg font-bold text-orange-500">Hola, 
              <span class="text-gray-700"><?php echo $nombreUsuario; ?></span>
            </h1>
            <span class="text-gray-400 text-xs font-bold uppercase"><?php echo $rolUsuario; ?></span>
        </div>
      </div>

      <!-- Navegación -->
      <nav class="mt-6 space-y-2">
        <a href="#" class="flex items-center gap-3 p-3 bg-orange-50 text-orange-600 rounded-xl font-bold transition-all">
          <span>
            <i class="fa-solid fa-house"></i>
          </span> 
          Inicio
        </a>
        <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-50 rounded-xl font-semibold transition-all">
          <span>
            <i class="fa-solid fa-users"></i>
          </span> 
          Personal
        </a>
        <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-50 rounded-xl font-semibold transition-all">
          <span>
          <i class="fa-solid fa-receipt"></i>
          </span> 
          Nómina
        </a>
      </nav>
    </div>

    <!-- Botón Cerrar Sesión -->
    <a href="../controllers/logout.php" class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition-all mt-auto">
      <span>
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
      </span> Cerrar sesión
    </a>
  </aside>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1 bg-white rounded-2xl shadow-xl p-8">
    <header class="border-b border-gray-100 pb-4">
      <h2 class="text-2xl font-bold text-gray-800">Tablero Principal</h2>
      <p class="text-gray-500 text-sm">Gestiona la información de la empresa desde aquí.</p>
    </header>
    
    <div class="mt-6">
      <p class="text-gray-700">Bienvenido al sistema administrativo de Nominy.</p>
    </div>
  </main>

</body>
</html>