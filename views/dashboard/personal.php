<?php 
/**
 * Vista de para RRHH para visualizar y modificar la informacion del personal
 */
$pageTitle = "Personal - Nominy";
include "layout.php";

if($_SESSION["name_role"] !== "RRHH"){
  header("Locaion: acess_denied.php");
  exit;
}
$personal = [
  [
    "id" => 1,
    "dni" => "V-24165273",
    "name" => "Bryant",
    "lastName" => "Facenda",
    "email" => "bryantffacen@gmail.com",
    "role" => "Development",
    "brith_date"=>"23-2-1900",
    "status" => 1
  ],
  [
    "id" => 2,
    "dni" => "V-25000000",
    "name" => "Carlos",
    "lastName" => "Gómez",
    "email" => "carlos@nominy.com",
    "role" => "Admin",
    "brith_date"=>"23-2-1900",
    "status" => 1
  ],
  [
    "id" => 3,
    "dni" => "V-26000000",
    "name" => "Ana",
    "lastName" => "López",
    "brith_date"=>"",
    "email" => "ana@nominy.com",
    "role" => "RRHH",
    "status" => 0
  ]
]
?>


<header class="border-b border-gray-100 pb-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Consulta la información de todo el personal</h1>
      <p class="text-sm text-gray-500">Gestiona la información de los usuarios del sistema.</p>
    </div>
    <button class="p-3 rounded-xl bg-orange-500 text-white font-bold cursor-pointer hover:bg-orange-600 transition-colors">
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
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Fecha de Ingreso</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase">Estado</th>
        <th class="p-4 text-xs font-bold text-gray-400 uppercase text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($personal as $usuario): ?>
        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
          <td class="p-4 text-gray-500 font-medium"><?php echo $usuario['dni']; ?></td>
          <td class="p-4 text-gray-700 font-bold"><?php echo $usuario['name'] . ' ' . $usuario['lastName']; ?></td>
          <td class="p-4 text-gray-600"><?php echo $usuario['email']; ?></td>
          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['role']; ?></td>
          <td class="p-4 text-gray-600 font-medium"><?php echo $usuario['brith_date']; ?></td>
          <td class="p-4">
            <?php if ($usuario['status'] === 1): ?>
              <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-bold">Activo</span>
            <?php else: ?>
              <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full font-bold">Pendiente</span>
            <?php endif; ?>
          </td>
          <td class="p-4 flex gap-2 justify-center">
            <!-- Botón Editar -->
            <button class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <!-- Botón Borrar -->
            <button class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors cursor-pointer" title="Eliminar">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<?php 
include __DIR__ . '/footer.php';
?>