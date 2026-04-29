<?php
$pageTitle = "Pago de nomina - Nominy";
include "layout.php";



/* $data = [
  [
    "status" => "PAGADO",
    "periode" => "sasas",
    "monto_pagado" => "12222",
    "bank" => "BBVA",
    "date" => "23-2-2303"
  ],
  [
    "status" => "PAGADO",
    "periode" => "sasas",
    "monto_pagado" => "12222",
    "bank" => "BBVA",
    "date" => "23-2-2303"
  ],
  [
    "status" => "PAGADO",
    "periode" => "sasas",
    "monto_pagado" => "12222",
    "bank" => "BBVA",
    "date" => "23-2-2303"
  ]
] */

?>
<header>
  <div>
    <h1 class="text-2xl font-bold text-gray-800">Mis Pagos Recientes</h1>
    <p class="text-sm text-gray-500">Consulta y descarga tus comprobantes de nómina.</p>
  </div>
</header>

<section class="mt-5">
  <?php if (empty($data)): ?>
    <div class="flex flex-col items-center justify-center p-12 border-2 border-dashed border-gray-200 rounded-[3rem] bg-gray-50/50 my-10">
      <div class="bg-white p-4 rounded-2xl shadow-sm mb-4">
        <i class="fa-solid fa-receipt text-4xl text-gray-300"></i>
      </div>
      <h3 class="text-lg font-bold text-gray-700">Sin historial de pagos</h3>
      <p class="text-gray-500 text-sm text-center max-w-xs mt-1">
        Aún no se han procesado pagos de nómina para tu cuenta en este periodo.
      </p>

      <button onclick="location.reload()" class="mt-6 px-5 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-100 transition-all">
        <i class="fa-solid fa-rotate-right mr-2"></i> Actualizar
      </button>
    </div>
  <?php else : ?>
    <?php foreach ($data as $item): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
        <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">

          <div class="flex justify-between items-start mb-4">
            <div class="bg-orange-100 text-orange-600 p-3 rounded-2xl">
              <i class="fa-solid fa-money-bill-transfer text-xl"></i>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase">
              <?php echo $item['status'] ?>
            </span>
          </div>

          <div class="mb-6">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider"><?php echo $item['periode'] ?></p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">
              $<?php echo number_format($item['monto_pagado'], 2) ?>
            </h3>
          </div>

          <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
            <div class="text-[11px] text-gray-400 leading-tight">
              <p class="font-medium">Depósito: <span class="text-gray-600"><?php echo $item['bank'] ?></span></p>
              <p>Fecha: <?php echo $item['date'] ?></p>
            </div>

            <a href="detalle_nomina.php?id=<?php echo $item['id'] ?? '123'; ?>"
              class="bg-orange-50 text-orange-500 p-2.5 rounded-xl hover:bg-orange-500 hover:text-white transition-all group">
              Ver recibo <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
          </div>

        </div>
      </div>

    <?php endforeach; ?>
  <?php endif; ?>

</section>