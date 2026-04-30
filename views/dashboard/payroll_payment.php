<?php
$pageTitle = "Pago de nomina - Nominy";
include "layout.php";

include "../../app/models/Users.php";
include "../../app/controllers/conexion.php";



$userModel = new Users($conn);
$works = $userModel->getUsers() ?: [];
$nominaDetallada = $userModel->getNominaTotal() ?: [];



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
<header class="border-b border-gray-100 pb-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Cierre de Nómina</h1>
      <p class="text-sm text-gray-500">Resumen de pagos netos incluyendo bonificaciones.</p>
    </div>
    <!-- Botón de Pago Masivo -->
    <button onclick="confirmarPagoTotal()" class="p-3 rounded-xl bg-green-600 text-white font-bold cursor-pointer hover:bg-green-700 transition-all active:scale-95 shadow-lg shadow-green-100">
      <i class="fa-solid fa-money-bill-transfer mr-2"></i>Pagar Nómina Total
    </button>
  </div>
</header>

<div class="mt-8 bg-white border border-gray-200 rounded-[2rem] overflow-hidden shadow-sm mb-10">
  <table class="w-full text-left">
    <thead>
      <tr class="bg-gray-50/50 border-b border-gray-200">
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Trabajador</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Sueldo Base</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Bonos Activos</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Neto a Pagar</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      <?php
      $granTotal = 0;
      foreach ($nominaDetallada as $item):
        $netoIndividual = $item['salary'] + $item['total_bonos'];
        $granTotal += $netoIndividual;
      ?>
        <tr class="hover:bg-green-50/30 transition-colors">
          <td class="p-4">
            <span class="block text-gray-700 font-bold text-sm"><?= $item['name'] . ' ' . $item['last_name'] ?></span>
            <span class="block text-gray-400 text-[10px] uppercase"><?= $item['dni'] ?></span>
          </td>
          <td class="p-4 text-gray-600 font-medium">$<?= number_format($item['salary'], 2) ?></td>
          <td class="p-4 text-green-600 font-bold">+$<?= number_format($item['total_bonos'], 2) ?></td>
          <td class="p-4 text-center">
            <span class="bg-slate-900 text-white text-xs px-4 py-2 rounded-xl font-black">
              $<?= number_format($netoIndividual, 2) ?>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
      <tr class="bg-slate-50">
        <td colspan="3" class="p-6 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Total a Desembolsar:</td>
        <td class="p-6 text-center">
          <span class="text-2xl font-black text-orange-500">$<?= number_format($granTotal, 2) ?></span>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  function openPayroll() {
    const modal = document.getElementById("modalPay");
    const btn = document.getElementById("openPayroll");

    modal.classList.remove("hidden")
    modal.classList.add("inline-flex")
  }

  function closePayroll() {
    const modal = document.getElementById("modalPay");

    modal.classList.remove(`inline-flex`);
    modal.classList.add(`hidden`)
  }
</script>