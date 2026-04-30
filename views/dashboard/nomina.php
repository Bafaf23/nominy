<?php
$pageTitle = "Mi nomina - Nominy";
include "layout.php";
include "../../app/controllers/conexion.php";


$id_usuario = $_SESSION['user_id'];
$sql = "SELECT id, amount as monto_pagado, period as periode, bank, 
                DATE_FORMAT(payment_date, '%d-%m-%Y') as date, 
                'PAGADO' as status 
        FROM individual_payments 
        WHERE id_user = ? 
        ORDER BY payment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

?>
<header>
  <div class="flex justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Mis Pagos Recientes</h1>
      <p class="text-sm text-gray-500">Consulta y descarga tus comprobantes de nómina.</p>
    </div>
  </div>
</header>

<section class="mt-5">
  <?php if (empty($data)): ?>

  <?php else : ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($data as $item): ?>
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

          </div>

        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>