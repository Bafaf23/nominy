<?php
$pageTitle = "Pago de nomina - Nominy";
include "layout.php";

include "../../app/models/Users.php";
include "../../app/controllers/conexion.php";


$sqlMovimientos = "SELECT status, periode, monto_pagado, bank, 
                          DATE_FORMAT(date, '%d/%m/%y %h:%i %p') as fecha_formateada 
                    FROM payroll_history 
                    ORDER BY date DESC 
                    LIMIT 10";
$resMovimientos = $conn->query($sqlMovimientos);
$movimientos = $resMovimientos->fetch_all(MYSQLI_ASSOC) ?: [];

?>
<header class="border-b border-gray-100 pb-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Cierre de Nómina</h1>
      <p class="text-sm text-gray-500">Resumen de pagos netos incluyendo bonificaciones.</p>
    </div>

  </div>
</header>

<section class="mt-12">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-800">Movimientos Recientes</h2>
    <span class="text-xs font-medium text-gray-400 uppercase tracking-widest">Últimos 10 registros</span>
  </div>

  <div class="space-y-4">
    <?php if (empty($movimientos)): ?>
      <p class="text-gray-400 text-sm italic">No hay movimientos registrados aún.</p>
    <?php else: ?>
      <?php foreach ($movimientos as $mov): ?>
        <div class="bg-white border border-gray-100 p-4 rounded-2xl flex items-center justify-between hover:shadow-sm transition-all">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full <?= $mov['status'] === 'PAID' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?> flex items-center justify-center">
              <i class="fa-solid <?= $mov['status'] === 'PAID' ? 'fa-arrow-up-from-bracket' : 'fa-circle-exclamation' ?>"></i>
            </div>
            <div>
              <p class="text-sm font-bold text-gray-700"><?= $mov['periode'] ?></p>
              <p class="text-[10px] text-gray-400 font-medium">
                <i class="fa-solid fa-bank mr-1"></i> <?= $mov['bank'] ?> • <?= $mov['fecha_formateada'] ?>
              </p>
            </div>
          </div>

          <div class="text-right">
            <p class="text-sm font-black text-gray-800">
              - $<?= number_format($mov['monto_pagado'], 2) ?>
            </p>
            <span class="text-[9px] font-bold px-2 py-0.5 rounded-md <?= $mov['status'] === 'PAID' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
              <?= $mov['status'] ?>
            </span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>