<?php

/**
 * Vista de para RRHH para visualizar y modificar la informacion del personal
 */
$pageTitle = "Personal - Nominy";
include "layout.php";

include "../../app/models/Users.php";
include "../../app/controllers/conexion.php";

if ($_SESSION["name_role"] !== "RRHH") {
  header("Location: acess_denied.php");
  exit;
}
$userModel = new Users($conn);
$personal = $userModel->getUsers() ?: [];

include "../components/molecule/modal_create_user.php";
include "../components/molecule/modal_edit_user.php";
include "../components/molecule/modal_buones.php";
?>


<header class="border-b border-gray-100 pb-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Gestión de Personal</h1>
      <p class="text-sm text-gray-500">Control total sobre usuarios, roles y beneficios.</p>
    </div>
    <div class="flex gap-2">
      <button onclick="abrirModal()" class="p-3 rounded-xl bg-orange-500 text-white font-bold cursor-pointer hover:bg-orange-600 transition-all active:scale-95 shadow-sm">
        <i class="fa-solid fa-user-plus mr-2"></i>Crear Usuario
      </button>
      <button onclick="openBonus()" class="p-3 rounded-xl bg-slate-900 text-white font-bold cursor-pointer hover:bg-slate-950 transition-all active:scale-95 shadow-sm">
        <i class="fa-solid fa-hand-holding-dollar mr-2"></i>Asignar Bono
      </button>
    </div>
  </div>
</header>

<section class="p-4 bg-amber-50 border border-amber-100 rounded-2xl mt-6 flex items-center gap-4">
  <div class="bg-amber-100 text-amber-600 w-10 h-10 flex items-center justify-center rounded-xl shadow-sm">
    <i class="fa-solid fa-circle-exclamation"></i>
  </div>
  <div>
    <h3 class="text-amber-900 font-bold text-xs uppercase tracking-widest">Validación Requerida</h3>
    <p class="text-amber-700 text-sm">Los usuarios en estado <span class="font-bold">Pendiente</span> no podrán acceder al sistema hasta ser activados.</p>
  </div>
</section>

<div class="mt-8 bg-white border border-gray-200 rounded-[2rem] overflow-hidden shadow-sm">
  <table class="w-full text-left">
    <thead>
      <tr class="bg-gray-50/50 border-b border-gray-200">
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Documento / Email</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nombre Completo</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Cargo / Salario</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Estado</th>
        <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      <?php foreach ($personal as $usuario): ?>
        <tr class="hover:bg-gray-50/50 transition-colors group">
          <td class="p-4">
            <span class="block text-gray-700 font-bold text-sm"><?php echo $usuario['dni']; ?></span>
            <span class="block text-gray-400 text-xs"><?php echo $usuario['email']; ?></span>
          </td>

          <td class="p-4 text-gray-800 font-bold"><?php echo $usuario['name'] . ' ' . $usuario['last_name']; ?></td>

          <td class="p-4">
            <span class="block text-gray-700 font-medium text-sm"><?php echo $usuario['name_role']; ?></span>
            <span class="block text-orange-500 font-bold text-xs">$<?php echo number_format($usuario['salary'], 2); ?></span>
          </td>

          <td class="p-4">
            <?php if ($usuario['is_active'] == 1): ?>
              <span class="bg-green-100 text-green-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-tighter">Activo</span>
            <?php else: ?>
              <span class="bg-yellow-100 text-yellow-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-tighter">Pendiente</span>
            <?php endif; ?>
          </td>

          <td class="p-4">
            <div class="flex gap-2 justify-center">
              <button onclick='abrirModalEditar(<?php echo json_encode($usuario); ?>)'
                class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all cursor-pointer shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>

              <form action="../../app/controllers/userControll.php" method="POST" class="inline">
                <input type="hidden" name="action" value="toggle_status">
                <input type="hidden" name="user_id" value="<?php echo $usuario['id_usuario']; ?>">
                <input type="hidden" name="new_status" value="<?php echo ($usuario['is_active'] == 1) ? '0' : '1'; ?>">

                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl transition-all shadow-sm cursor-pointer <?php echo ($usuario['is_active'] == 1) ? 'bg-red-50 text-red-600 hover:bg-red-600 hover:text-white' : 'bg-green-50 text-green-600 hover:bg-green-600 hover:text-white'; ?>">
                  <i class="fa-solid <?php echo ($usuario['is_active'] == 1) ? 'fa-user-slash' : 'fa-user-check'; ?>"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

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

    document.getElementById('edit_id').value = usuario.id_usuario;
    document.getElementById('edit_name').value = usuario.name;
    document.getElementById('edit_last_name').value = usuario.last_name;
    document.getElementById('edit_dni').value = usuario.dni;
    document.getElementById('edit_email').value = usuario.email;
    document.getElementById('edit_date').value = usuario.date_entry;


    if (document.getElementById('edit_role')) {
      document.getElementById('edit_role').value = usuario.id_role;
    }

    document.getElementById('edit_bank_account').value = usuario.account || '';
    document.getElementById('edit_bank_name').value = usuario.name_bank || '';

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function cerrarModalEditar() {
    const modal = document.getElementById('modalEditarUsuario');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function openBonus() {
    const modal = document.getElementById("modalBonus")
    const btn = document.getElementById("openBonus")

    modal.classList.remove("hidden")
    modal.classList.add("flex")
  }

  function closeBonus() {
    const modal = document.getElementById('modalBonus');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
<?php
include __DIR__ . '/footer.php';
?>