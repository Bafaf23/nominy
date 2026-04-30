<?php
$pageTitle = "Panel inicio - Nominy";
include "layout.php";

$salary = $_SESSION['salary'] ?? 0;
$bones = $_SESSION['bonuses'] ?? [];

$totalBonesAmount = 0;
if (is_array($bones)) {
  foreach ($bones as $bono) {
    $totalBonesAmount += (float)($bono["monte"] ?? 0);
  }
}

$grandTotal = $salary + $totalBonesAmount;

$info = [
  ["label" => "Fecha de ingreso", "value" => $_SESSION['date_entry'] ?? "No asignada"],
  ["label" => "Salario Base",    "value" => "$" . number_format($salary, 2)],
  ["label" => "Total Bonos",     "value" => "$" . number_format($totalBonesAmount, 2)],
  ["label" => "Cargo",           "value" => $_SESSION['name_role'] ?? "No asignado"],
  ["label" => "Sueldo Neto",     "value" => "$" . number_format($grandTotal, 2)]
];
?>

<header class="border-b border-gray-100 pb-4">
  <h2 class="text-2xl font-bold text-gray-800">Tablero Principal</h2>
  <p class="text-gray-500 text-sm">Consulta tu información laboral aquí.</p>
</header>

<section class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4">
  <?php foreach ($info as $item): ?>
    <div class="p-5 border border-gray-100 rounded-2xl flex flex-col gap-1 shadow-sm bg-white hover:shadow-md transition-shadow">
      <h3 class="text-[10px] font-bold uppercase text-gray-400 tracking-wider"><?php echo $item["label"]; ?></h3>
      <p class="text-xl font-black text-gray-800"><?php echo $item["value"]; ?></p>
    </div>
  <?php endforeach; ?>
</section>

<section class="mt-8 flex flex-col lg:flex-row gap-6">
  <div class="lg:w-1/2 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
    <h2 class="text-gray-800 font-bold mb-4 flex items-center gap-2">
      <i class="fa-solid fa-coins text-orange-500"></i> Bonos Detallados
    </h2>
    <div class="space-y-3">
      <?php if (empty($bones)): ?>
        <div class="p-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200 text-center">
          <p class="text-gray-400 font-medium">No tienes bonos asignados en este periodo.</p>
        </div>
      <?php else: ?>
        <?php foreach ($bones as $bono): ?>
          <div class="p-4 bg-orange-50/50 rounded-2xl border border-orange-100 flex justify-between items-center">
            <div>
              <p class="text-[10px] text-orange-400 font-bold uppercase">Concepto</p>
              <p class="text-gray-700 font-bold"><?php echo $bono["nameBone"]; ?></p>
            </div>
            <div class="text-right">
              <p class="text-[10px] text-orange-400 font-bold uppercase">Monto</p>
              <p class="text-orange-600 font-black text-lg">$<?php echo number_format($bono["monte"], 2); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="lg:w-1/2">
    <h2 class="text-gray-800 font-bold mb-4">Noticias y Tips</h2>
    <div class="relative h-full min-h-[250px] rounded-[2rem] overflow-hidden group shadow-lg">
      <img src="https://mrrecluta.com/wp-content/uploads/2025/05/blog-por-que-la-gestion-de-nomina-es-clave.webp"
        class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
      <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
      <div class="absolute bottom-0 left-0 p-8">
        <span class="bg-orange-500 text-white text-[10px] px-3 py-1 rounded-full font-black uppercase shadow-lg">Novedad</span>
        <h3 class="text-white font-bold text-2xl mt-3 leading-tight">Optimiza tu gestión de tiempo</h3>
        <p class="text-gray-300 text-sm mt-2 opacity-90">Mejora tu productividad con las nuevas herramientas de Nominy.</p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>