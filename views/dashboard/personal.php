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
      <h1 class="text-2xl font-bold text-gray-800">Consulta la información de todo el personal</h1>
      <p class="text-sm text-gray-500">Gestiona la información de los usuarios del sistema.</p>
    </div>
    <button onclick="abrirModal()" class="p-3 rounded-xl bg-orange-500 text-white font-bold cursor-pointer hover:bg-orange-600 transition-colors">
      <i class="fa-solid fa-user-plus mr-2"></i>Crear Usuario
    </button>
  </div>
</header>

<section class="p-5 bg-amber-50 border border-amber-200 rounded-2xl mt-4 flex flex-row items-center gap-3 shadow-xs">
  <span class="text-amber-600 text-xl">
    <i class="fa-solid fa-user-check"></i>
  </span>
  <div>
    <h3 class="text-amber-800 font-bold text-sm uppercase tracking-wide">Recordatorio de Validación</h3>
    <p class="text-amber-700 text-sm mt-0.5">Recuerda actualizar los datos de los usuarios y validar su estado para que puedan ingresar al sistema.</p>
  </div>
</section>

<!-- TABLA DE PERSONAL -->
<section class="mt-6 border border-gray-200 rounded-2xl overflow-hidden shadow-xs">
  <table class="w-full text-left border-collapse">
    <thead>
      <tr class="bg-gray-50 border-b border-gray-200">
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Documento</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Nombre Completo</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Email</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Cargo</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Salario</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Fecha de Ingreso</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Banco</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Estado</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($personal as $usuario): ?>
        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
          <td class="p-4 text-gray-500 font-medium"><?php echo $usuario['dni']; ?></td>

          <td class="p-4 text-gray-700 font-bold"><?php echo $usuario['name'] . ' ' . $usuario['last_name']; ?></td>
          <td class="p-4 text-gray-600"><?php echo $usuario['email']; ?></td>

          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['name_role']; ?></td>

          <td class="p-4 text-gray-600 font-medium"><?php echo '$' . number_format($usuario['salary'], 2); ?></td>
          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['date_entry']; ?></td>
          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['name_bank']; ?></td>

          <td class="p-4">
            <?php if ($usuario['is_active'] == 1): ?>
              <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-bold">Activo</span>
            <?php else: ?>
              <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full font-bold">Pendiente</span>
            <?php endif; ?>
          </td>

          <td class="p-4 flex gap-2 justify-center">
            <button onclick="abrirModalEditar(<?php echo htmlspecialchars(json_encode($usuario)); ?>)" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>

            <form action="../../app/controllers/userControll.php" method="POST" class="inline">
              <input type="hidden" name="action" value="toggle_status">
              <input type="hidden" name="user_id" value="<?php echo $usuario['id_usuario']; ?>">
              <input type="hidden" name="new_status" value="<?php echo ($usuario['is_active'] == 1) ? '0' : '1'; ?>">

              <?php if ($usuario['is_active'] == 1): ?>
                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100 cursor-pointer" title="Desactivar">
                  <i class="fas fa-user-slash"></i>
                </button>
              <?php else: ?>
                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-green-50 text-green-600 rounded-lg hover:bg-green-100 cursor-pointer" title="Activar">
                  <i class="fa-solid fa-user-check"></i>
                </button>
              <?php endif ?>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<script>
  function abrirModal() {
    const modal = document.getElementById('modalCrearUsuario');
    modal.classList.remove('hidden');
    modal.classList.add("inline-flex")
  }

  function cerrarModal() {
    const modal = document.getElementById('modalCrearUsuario');
    modal.classList.add('hidden');
    modal.classList.remove("inline-flex")
  }

  function abrirModalEditar(usuario) {
    const modal = document.getElementById('modalEditarUsuario');

    // Rellenamos los campos con los datos que vienen de la fila
    document.getElementById('edit_id').value = usuario.id_usuario; // El alias que creamos
    document.getElementById('edit_name').value = usuario.name;
    document.getElementById('edit_last_name').value = usuario.last_name;
    document.getElementById('edit_dni').value = usuario.dni;
    document.getElementById('edit_email').value = usuario.email
    document.getElementById('edit_role').value = usuario.name_role
    document.getElementById('edit_date').value = usuario.date_entry
    // Mostramos el modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function cerrarModalEditar() {
    const modal = document.getElementById('modalEditarUsuario');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
<?php
include __DIR__ . '/footer.php';
?>