<?php
$links = [
  [
    "icon" => '<i class="fa-solid fa-house"></i>',
    "label" => "Inicio",
    "href" => "dashboard.php"
  ],
  [
    "icon" => '<i class="fa-solid fa-users"></i>',
    "label" => "Personal",
    "href" => "personal.php",
  ],
  [
    "icon" => '<i class="fa-solid fa-receipt"></i>',
    "label" => "Mi nomina",
    "href" => "nomina.php"
  ],
  [
    "icon" => '<i class="fa-solid fa-money-bill-transfer"></i>',
    "label" => "Pago de Nomina",
    "href" => "payroll_payment.php"
  ]
]
?>
<aside class="w-72 bg-white rounded-2xl shadow-xl p-6 flex flex-col justify-between">
  <div>
    <!-- Perfil -->
    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
      <div class="bg-orange-100 w-12 h-12 rounded-full flex justify-center items-center text-orange-600 font-bold text-xl">
        <span><?php echo $inicial; ?></span>
      </div>
      <div>
        <h1 class="text-lg font-bold text-orange-500">Hola,
          <span class="text-gray-700"> <?php echo $_SESSION["name"]; ?></span>
        </h1>
        <span class="text-gray-400 text-xs font-bold uppercase"> <?php echo $_SESSION["name_role"]; ?></span>
      </div>
    </div>

    <!-- Navegación -->
    <nav class="mt-6 space-y-2">
      <?php
      $router = basename($_SERVER['SCRIPT_NAME']);
      $rol_actual = isset($_SESSION["name_role"]) ? $_SESSION["name_role"] : "";

      foreach ($links as $link) {
        $isActive = ($router === $link["href"]);

        if ($link["label"] === "Personal" && $rol_actual !== "RRHH") {
          continue;
        }

        if ($link["label"] === "Pago de Nomina" && $rol_actual !== "RRHH") {
          continue;
        }
        
        $class = $isActive ? 'bg-orange-50 text-orange-600 font-bold' : 'text-gray-600 hover:bg-gray-50 font-semibold';

        echo '
          <a href="' . $link["href"] . '" class="flex items-center gap-3 p-3 ' . $class . ' rounded-xl transition-all">
            <span>' . $link["icon"] . '</span> 
            ' . $link["label"] . '
          </a>
        ';
      }
      ?>
    </nav>
  </div>


  <!-- Botón Cerrar Sesión -->
  <form action="../../app/controllers/logoutControll.php" method="POST" class="mt-auto">
    <button type="submit" class="w-full flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition-all">
      <span>
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
      </span>
      Cerrar sesión
    </button>
  </form>
  <footer class="mt-2 text-gray-400 text-xs font-medium">
    &copy; 2026 Nominy. Todos los derechos reservados - Bryant Facenda
  </footer>
</aside>