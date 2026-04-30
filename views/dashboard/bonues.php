<?php

/**
 * Vista de para RRHH para visualizar y modificar la informacion del personal
 */
$pageTitle = "Personal - Nominy";
include "layout.php";

include "../../app/models/Users.php";
include "../../app/controllers/conexion.php";
include "../components/molecule/modal_create_user.php";
include "../components/molecule/modal_edit_user.php";

if ($_SESSION["name_role"] !== "RRHH") {
  header("Location: acess_denied.php");
  exit;
}
$userModel = new Users($conn);
$personal = $userModel->getUsers() ?: [];
?>


<header class="border-b border-gray-100 pb-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Consulta la información de los bonos asigandos a los trabajadores</h1>
      <p class="text-sm text-gray-500">Gestiona la información de los usuarios del sistema.</p>
    </div>
    <button onclick="abrirModal()" class="p-3 rounded-xl bg-orange-500 text-white font-bold cursor-pointer hover:bg-orange-600 transition-colors">
      <i class="fa-solid fa-plus mr-2"></i>Asignar Bono
    </button>
  </div>
</header>

<!-- TABLA DE BONOS -->
<section class="mt-6 border border-gray-200 rounded-2xl overflow-hidden shadow-xs">
  <table class="w-full text-left border-collapse">
    <thead>
      <tr class="bg-gray-50 border-b border-gray-200">
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Documento</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Nombre Completo</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Cargo</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Salario</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Fecha de Ingreso</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Bonos</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($personal as $usuario): ?>
        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
          <td class="p-4 text-gray-500 font-medium"><?php echo $usuario['dni']; ?></td>

          <td class="p-4 text-gray-700 font-bold"><?php echo $usuario['name'] . ' ' . $usuario['last_name']; ?></td>

          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['name_role']; ?></td>

          <td class="p-4 text-gray-600 font-medium"><?php echo '$' . number_format($usuario['salary'], 2); ?></td>
          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['date_entry']; ?></td>
          <td>
            <?php if ($usuario['bonues']): ?>
              <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded-lg text-xs font-bold">
                <?= $usuario['bonues'] ?>
              </span>
            <?php else: ?>
              <span class="text-gray-400 text-xs italic">Sin bonos</span>
            <?php endif; ?>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<?php
include __DIR__ . '/footer.php';
?>