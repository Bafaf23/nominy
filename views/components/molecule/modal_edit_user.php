<div id="modalEditarUsuario" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm items-center justify-center z-50 p-4">
  <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg p-8 overflow-y-auto max-h-[90vh]">

    <header class="mb-6">
      <h2 class="text-2xl font-black text-gray-800">Actualizar Empleado</h2>
      <p class="text-sm text-gray-500">Modifica los datos contractuales y personales.</p>
    </header>

    <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-xl flex items-center gap-3 mb-6">
      <i class="fa-solid fa-circle-info text-amber-500 text-lg"></i>
      <p class="text-xs font-semibold">
        El Documento (C.I.) es inmutable por seguridad. Contacta a <span class="underline">Soporte TI</span> para cambios legales.
      </p>
    </div>

    <form action="../../app/controllers/userControll.php" method="POST" class="space-y-5">
      <input type="hidden" name="action" value="update_user">
      <input type="hidden" name="user_id" id="edit_id">

      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Nombre</label>
          <input type="text" id="edit_name" name="edit_name" required
            class="border border-gray-200 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Apellido</label>
          <input type="text" id="edit_last_name" name="edit_last_name" required
            class="border border-gray-200 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
        </div>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">C.I.</label>
          <input type="text" id="edit_dni" name="edit_dni" readonly
            class="border border-gray-200 p-3 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed outline-none">
        </div>
        <div class="flex flex-col gap-1.5 col-span-2">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Fecha de Ingreso</label>
          <input type="date" id="edit_date" name="edit_date" required
            class="border border-gray-200 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
        </div>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div class="flex flex-col gap-1.5 col-span-2">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Correo Electrónico</label>
          <input type="email" id="edit_email" name="edit_email" required
            class="border border-gray-200 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Cargo</label>
          <select name="edit_role" id="edit_role"
            class="border border-gray-200 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium">
            <option value="1">Development</option>
            <option value="2">RRHH</option>
            <option value="3">Marketing</option>
            <option value="4">QA</option>
            <option value="5">Design</option>
            <option value="6">Accounting</option>
          </select>
        </div>
      </div>

      <hr class="border-gray-100 my-2">

      <div class="grid grid-cols-3 gap-2">
        <div class="flex flex-col gap-1.5 col-span-2">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Número de Cuenta</label>
          <div class="relative">
            <span class="absolute left-3 top-3.5 text-gray-400"><i class="fa-solid fa-building-columns"></i></span>
            <input type="text" id="edit_bank_account" name="edit_bank_account" maxlength="20" placeholder="0102..."
              class="w-full border border-gray-200 p-3 pl-10 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
          </div>
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-bold text-gray-400 uppercase ml-1">Nombre del Banco</label>
          <div class="relative">
            <span class="absolute left-3 top-3.5 text-gray-400"><i class="fa-solid fa-building-columns"></i></span>
            <input type="text" id="edit_bank_name" name="edit_bank_name" maxlength="20" placeholder="Mercantil"
              class="w-full border border-gray-200 p-3 pl-10 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700">
          </div>
        </div>
      </div>

      <div class="mt-8 flex gap-3">
        <button type="button" onclick="cerrarModalEditar()"
          class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
          Cancelar
        </button>
        <button type="submit"
          class="flex-1 px-4 py-3 bg-orange-500 text-white rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all">
          Guardar Cambios
        </button>
      </div>
    </form>
  </div>
</div>