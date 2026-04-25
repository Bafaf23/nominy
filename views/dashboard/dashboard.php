<?php
$pageTitle = "Panel inicio - Nominy";

include "layout.php";

?>
<!-- CONTENIDO PRINCIPAL -->

<header class="border-b border-gray-100 pb-4">
  <h2 class="text-2xl font-bold text-gray-800">Tablero Principal</h2>
  <p class="text-gray-500 text-sm">Consulta tu informacion laboral aqui.</p>
</header>

<div class="mt-6">
  <p class="text-gray-700 font-medium">Bienvenido al sistema administrativo de Nominy.</p>
</div>

<section class="mt-6 flex gap-2 flex-row justify-evenly">
  <?php
    $info = [
      [ 
        "label" => "Fecha de ingreso", 
        "value" => "23-2-2003" 
      ],
      [ 
        "label" => "Salario", 
        "value" => "$2323" 
      ],
      [ 
        "label" => "Bono", 
        "value" => "$2323" 
      ],
      [ 
        "label" => "Cargo", 
        "value" => "Development" 
      ],
      [ 
        "label" => "Salario total", 
        "value" => "$2333" 
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
  <section  ection class="w-1/2 border-r border-gray-300 p-2">
    <h2 class="text-gray-600 font-medium">Bonos de tallados</h2>
      <section class="mt-4">
        <?php
          $bones = [
            [
              "nameBone"=>"Trasnporte", 
              "monte"=> "$20"
            ]
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
    </section>
</section>

<?php 
include __DIR__ . '/footer.php';
?>
