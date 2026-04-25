<?php
$pageTitle = "Mi nomina - Nominy";
include "layout.php";

$user = [
  "dni" => "V-30021867",
  "name"=> "Bryant",
  "lastName" => "Facenda",
  "role" => "Development",
  "bank" => "BBVA",
  "countBank" => "123456789987"
];
?>

<header class="flex flex-col gap-4">
  <div>
    <h1 class="text-2xl font-bold text-gray-800">Comprobante de nómina</h1>
    <p class="text-sm text-gray-500">Documento de pago para el trabajador.</p>
  </div>
  <!-- de la empresa -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Bloque de la Empresa -->
    <div class="p-5 bg-gray-50 border border-gray-200 rounded-2xl shadow-xs">
      <div class="flex items-center gap-2 border-b border-gray-100 pb-3 mb-3">
        <span class="text-orange-500"><i class="fa-solid fa-building"></i></span>
        <h3 class="font-bold text-gray-700">Información del Patrono</h3>
      </div>
      <div class="space-y-2">
        <div>
          <p class="text-xs text-gray-400 font-bold uppercase">Razón Social</p>
          <p class="text-gray-700 font-bold text-lg">Nominy, C.A.</p>
        </div>
        <div>
          <p class="text-xs text-gray-400 font-bold uppercase">R.I.F.</p>
          <p class="text-gray-600 font-medium">J-2003230-4</p>
        </div>
      </div>
    </div>
    <!--bloque del empleado -->
    <div class="p-5 bg-gray-50 border border-gray-200 rounded-2xl shadow-xs">
      <div class="flex items-center gap-2 border-b border-gray-100 pb-3 mb-3">
        <span class="text-orange-500"><i class="fa-solid fa-user"></i></span>
        <h3 class="font-bold text-gray-700">Información del Empleado</h3>
      </div>
      <div class="space-y-2">
        <div>
          <p class="text-xs text-gray-400 font-bold uppercase">Nombres y Apellidos</p>
          <p class="text-gray-700 font-bold text-lg"><?php echo $user['name'] . ' ' . $user['lastName']; ?></p>
        </div>
        <div class="flex justify-between">
          <div>
            <p class="text-xs text-gray-400 font-bold uppercase">Cédula de Identidad</p>
            <p class="text-gray-600 font-medium"><?php echo $user['dni']; ?></p>
          </div>
          <div class="text-right">
            <p class="text-xs text-gray-400 font-bold uppercase">Cargo</p>
            <p class="text-gray-600 font-medium"><?php echo $user['role']; ?></p>
          </div>
        </div>
      </div>
    </div>
    <!-- Banco receptor -->
    <div class="p-5 bg-gray-50 border border-gray-200 rounded-2xl shadow-xs">
      <div class="flex items-center gap-2 border-b border-gray-100 pb-3 mb-3">
        <span class="text-orange-500"><i class="fa-solid fa-bank"></i></span>
        <h3 class="font-bold text-gray-700">Informacion del Banco Receptor</h3>
      </div>
      <div class="space-y-2">
        <div>
          <p class="text-xs text-gray-400 font-bold uppercase">Banco</p>
          <p class="text-gray-700 font-bold text-lg"><?php echo $user['bank']; ?></p>
        </div>
        <div class="flex justify-between">
          <div>
            <p class="text-xs text-gray-400 font-bold uppercase">Numero de cuenta</p>
            <p class="text-gray-600 font-medium"><?php echo $user['countBank']; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<?php
// Datos de prueba para el recibo de pago
$conceptos = [
  [
    "codigo" => "001",
    "concepto" => "Sueldo Base (Quincenal)",
    "asignacion" => 1200.00,
    "deduccion" => 0.00
  ],
  [
    "codigo" => "002",
    "concepto" => "Bono de Transporte",
    "asignacion" => 50.00,
    "deduccion" => 0.00
  ],
  [
    "codigo" => "101",
    "concepto" => "Seguro Social Obligatorio",
    "asignacion" => 0.00,
    "deduccion" => 48.00
  ],
  [
    "codigo" => "102",
    "concepto" => "Fondo de Pensiones",
    "asignacion" => 0.00,
    "deduccion" => 24.00
  ]
];

$total_asig = 0;
$total_dedu = 0;
?>

<section class="mt-6 border border-gray-200 rounded-2xl overflow-hidden shadow-xs">
  <table class="w-full text-left border-collapse">
    <!-- Cabecera de la Tabla -->
    <thead>
      <tr class="bg-gray-50 border-b border-gray-200">
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Código</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Concepto</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase text-right">Asignación</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase text-right">Deducción</th>
      </tr>
    </thead>
    
    <!-- Cuerpo de la Tabla -->
    <tbody>
      <?php foreach ($conceptos as $item): 
        $total_asig += $item['asignacion'];
        $total_dedu += $item['deduccion'];
      ?>
        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
          <td class="p-4 text-gray-500 font-medium"><?php echo $item['codigo']; ?></td>
          <td class="p-4 text-gray-700 font-bold"><?php echo $item['concepto']; ?></td>
          <td class="p-4 text-gray-700 text-right font-medium">
            <?php echo $item['asignacion'] > 0 ? '$' . number_format($item['asignacion'], 2) : '-'; ?>
          </td>
          <td class="p-4 text-red-500 text-right font-medium">
            <?php echo $item['deduccion'] > 0 ? '-$' . number_format($item['deduccion'], 2) : '-'; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

    <!-- Totales y Saldo Neto -->
    <tfoot>
      <tr class="bg-gray-50 border-t border-gray-200">
        <td colspan="2" class="p-4 text-gray-600 font-bold text-right">Totales:</td>
        <td class="p-4 text-gray-700 font-bold text-right">$<?php echo number_format($total_asig, 2); ?></td>
        <td class="p-4 text-red-500 font-bold text-right">-$<?php echo number_format($total_dedu, 2); ?></td>
      </tr>
      <tr class="bg-orange-50">
        <td colspan="2" class="p-4 text-orange-600 font-bold text-right text-lg">Saldo Neto a Recibir:</td>
        <td colspan="2" class="p-4 text-orange-600 font-extrabold text-right text-2xl">
          $<?php echo number_format($total_asig - $total_dedu, 2); ?>
        </td>
      </tr>
    </tfoot>
  </table>
</section>

<?php
include "footer.php";
?>