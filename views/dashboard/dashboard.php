<?php
$pageTitle = "Panel inicio - Nominy";

include "layout.php";
?>

<header class="border-b border-gray-100 pb-4">
  <h2 class="text-2xl font-bold text-gray-800">Tablero Principal</h2>
  <p class="text-gray-500 text-sm">Consulta tu informacion laboral aqui.</p>
</header>

<div class="mt-6">
  <p class="text-gray-700 font-medium">Bienvenido al sistema administrativo de Nominy.</p>
</div>

<section class="mt-6 flex gap-2 flex-row justify-evenly">
  <?php
  $salary =  $_SESSION['salary'];
  $bone = $_SESSION['id_bonuses'] ? 0 : 0;

    $info = [
      [ 
        "label" => "Fecha de ingreso", 
        "value" => isset($_SESSION['date_entry']) ? $_SESSION['date_entry'] : "No asignada"
      ],
      [ 
        "label" => "Salario", 
        "value" =>isset($_SESSION['salary']) ? "$" . $_SESSION['salary'] : "No asignada" 
      ],
      [ 
        "label" => "Bono", 
        "value" => isset($_SESSION['id_bonuses']) ? $_SESSION['id_bonuses'] : "No asignada" 
      ],
      [ 
        "label" => "Cargo", 
        "value" => isset($_SESSION['name_role']) ? $_SESSION['name_role'] : "No asignada"
      ],
      [ 
        "label" => "Salario total", 
        "value" =>"$". $salary + $bone, 
      ]
    ];

    foreach ($info as $item){
      ?>
        <div class="p-5 border border-gray-200 rounded-2xl flex flex-col gap-3 w-55 shadow">
          <h3 class="text-xl text-orange-500"><?php echo ucwords($item["label"]); ?></h3>
          <p class="text-orange-500 text-2xl font-bold"><?php echo $item["value"]; ?></p>
        </div>
      <?php 
      }
      ?>
</section>

<section class="mt-6 bg-gray-50 border border-gray-200 rounded-2xl flex flex-row flex-1 p-1 gap-2">
  <section class="w-1/2 border-r border-gray-300 p-2">
    <h2 class="text-gray-600 font-medium">Bonos de tallados</h2>
      <section class="mt-4">
        <?php
          $bones = [
            
          ];

            if(empty($bones)){
              echo '
                <div class="p-5 bg-gray-200 rounded-2xl border border-gray-300">
                  <span class="text-gray-400 font-bold">No tienes bonos asignados</span>
                </div>
                ';
            } else {
              foreach ($bones as $bono) {
                echo '
                <div class="p-5 bg-orange-50 rounded-2xl border border-orange-200 flex justify-between items-center mb-2">
                  <div>
                    <p class="text-xs text-gray-400 font-bold uppercase">Concepto</p>
                    <p class="text-gray-700 font-bold">' . $bono["nameBone"] . '</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-400 font-bold uppercase text-right">Monto</p>
                    <p class="text-orange-500 font-bold text-xl">' . $bono["monte"] . '</p>
                  </div>
                </div>
                ';
            }
            }
          ?>
      </section>
  </section>

    <section class="w-1/2 p-2">
      <h2 class="text-gray-600 font-medium">Noticias</h2>
      
      <div class="relative h-90 w-full rounded-2xl overflow-hidden group shadow-xs mt-3">
        <!-- Imagen optimizada: object-cover evita que se estire -->
        <img src="https://mrrecluta.com/wp-content/uploads/2025/05/blog-por-que-la-gestion-de-nomina-es-clave.webp" alt="Información sobre gestión de nómina" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" > 
        <!-- Capa de sombra (Overlay) para que el texto blanco sea 100% legible -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        <!-- Texto posicionado en la esquina inferior -->
        <div class="absolute bottom-0 left-0 p-5">
          <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-lg font-bold uppercase">Tips</span>
            <h3 class="text-white font-bold text-xl mt-2">¡La mejor forma de llevar tu nómina!</h3>
            <p class="text-gray-200 text-sm mt-1">Descubre cómo optimizar los procesos de tu empresa.</p>
        </div>
      </div>
    </section>
</section>

<?php 
include __DIR__ . '/footer.php';
?>
