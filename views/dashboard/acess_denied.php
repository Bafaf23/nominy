<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url_retorno = isset($_SESSION['user_id']) ? "dashboard.php" : "../index.php";
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
  <title>Acceso Denegado | Nominy</title>
</head>
<body class="bg-gray-100 h-screen flex flex-col justify-center items-center p-4">

  <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-10 text-center flex flex-col items-center">
    
    <!-- Icono Ilustrativo de Bloqueo -->
    <div class="bg-red-50 w-24 h-24 rounded-full flex justify-center items-center text-red-500 mb-6">
      <span class="text-5xl">
        <i class="fa-solid fa-user-lock"></i>
      </span>
    </div>

    <!-- Mensajes -->
    <h1 class="text-4xl font-extrabold text-gray-800">403</h1>
    <h2 class="text-xl font-bold text-gray-700 mt-2">Acceso Denegado</h2>
    
    <p class="text-gray-500 text-sm mt-4 leading-relaxed">
      No posees los permisos necesarios para visualizar esta sección. Si crees que esto es un error, por favor comunícate con el departamento de <span class="font-bold">Recursos Humanos</span>.
    </p>

    <!-- Línea divisora -->
    <div class="border-b border-gray-100 w-full my-6"></div>

    <!-- Botón de Acción -->
    <a href="<?php echo $url_retorno; ?>" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold p-4 rounded-xl transition-all active:scale-95 shadow-lg shadow-orange-200 cursor-pointer">
      <i class="fa-solid fa-arrow-left mr-2"></i>Regresar al Sistema
    </a>

    <!-- Enlace Secundario -->
    <div class="mt-4">
      <a href="../app/controllers/logoutControll.php" class="text-sm text-gray-400 hover:text-red-500 font-semibold transition-colors">
        Finalizar Sesión
      </a>
    </div>

  </div>

  <!-- Pie de página simple -->
  <footer class="mt-6 text-gray-400 text-xs font-medium">
    &copy; 2026 Nominy. Todos los derechos reservados.
  </footer>

</body>
</html>