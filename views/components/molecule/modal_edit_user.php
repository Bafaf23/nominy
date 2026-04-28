<div id="modalEditarUsuario" class="hidden fixed inset-0 bg-gray-900/50 items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
    <h2 class="text-xl font-bold mb-4 text-orange-500">Actualizar Informacion del Usuario</h2>

    <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg flex items-center gap-3 my-4">
      <i class="fa-solid fa-circle-info text-amber-500"></i>
      <p class="text-sm font-medium">
        ¿Hay un error en la C.I? Contacta al equipo de **Soporte TI** para actualizarla.
      </p>
    </div>

    <form action="../../app/controllers/userControll.php" method="POST">
      <input type="hidden" name="action" value="update_user">
      <input type="hidden" name="user_id" id="edit_id">

      <div class="space-y-4">
        <div class="grid grid-cols-3 gap-3">
          <!-- Docuemento -->
          <div class="flex flex-col gap-2">
            <label for="edit_dni" class="font-semibold text-gray-700">Docuemento</label>
            <input
              type="text"
              id="edit_dni"
              name="edit_dni"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
              placeholder="V-24165273"
              readonly>
          </div>
          <!-- Fecha de ingreso -->
          <div class="flex flex-col gap-2 col-span-2 place-content-end">
            <label for="edit_date" class="font-semibold text-gray-700">Fecha de ingreso</label>
            <input
              type="date"
              id="edit_date"
              name="edit_date"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
              placeholder="23/09/2102" require>
          </div>
        </div>
        <!-- nombre y apellido -->
        <div class="grid grid-cols-2 gap-2">
          <div class="flex flex-col gap-2">
            <label for="edit_name" class="font-semibold text-gray-700">Nombre</label>
            <input
              type="text"
              id="edit_name"
              name="edit_name"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
              placeholder="Juan"
              required>
          </div>
          <div class="flex flex-col gap-2">
            <label for="edit_last_name" class="font-semibold text-gray-700">Apellido</label>
            <input
              type="text"
              id="edit_last_name"
              name="edit_last_name"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
              placeholder="Fernandez"
              required>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-3">
          <div class="flex flex-col gap-2 col-span-2">
            <label for="edit_email" class="font-semibold text-gray-700">Email</label>
            <input
              type="email"
              id="edit_email"
              name="edit_email"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
              placeholder="ejemplo@correo.com"
              required>
          </div>
          <div class="flex flex-col gap-2">
            <label for="edit_role" class="font-semibold text-gray-700">Cargo</label>
            <select name="edit_role" id="edit_role" class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all">
              <option value="2">RRHH</option>
              <option value="1">Development</option>
              <option value="3">Marketing</option>
              <option value="4">QA</option>
              <option value="5">Design</option>
              <option value="6">Accounting and Sales</option>
            </select>
          </div>
        </div>


      </div>

      <div class="mt-6 flex justify-end gap-3">
        <button type="button" onclick="cerrarModalEditar()" class="px-4 py-2 bg-gray-200 rounded">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded shadow">Guardar</button>
      </div>
    </form>
  </div>
</div>