<div id="modalCrearUsuario" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm items-center justify-center z-50 p-4">
  <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl transform transition-all overflow-hidden border border-gray-100">

    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
      <div class="flex items-center gap-3">
        <div class="bg-orange-500 text-white p-2 rounded-lg">
          <i class="fa-solid fa-user-plus"></i>
        </div>
        <h2 class="text-xl font-black text-gray-800">Nuevo Trabajador</h2>
      </div>
      <button onclick="cerrarModal()" class="text-gray-400 hover:text-red-500 transition-colors text-2xl">&times;</button>
    </div>

    <form action="../../app/controllers/userControll.php" method="POST" class="p-8 space-y-5">
      <input type="hidden" name="action" value="register">
      <input type="hidden" name="origen" value="rrhh">

      <div class="flex flex-col gap-2">
        <label for="dni" class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Documento de Identidad</label>
        <input
          type="text"
          id="dni"
          name="dni"
          class="border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
          placeholder="V-24165273"
          required>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-2">
          <label for="name" class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Nombre</label>
          <input
            type="text"
            id="name"
            name="name"
            class="border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
            placeholder="Juan"
            required>
        </div>
        <div class="flex flex-col gap-2">
          <label for="lastName" class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Apellido</label>
          <input
            type="text"
            id="lastName"
            name="lastName"
            class="border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
            placeholder="Fernández"
            required>
        </div>
      </div>

      <div class="flex flex-col gap-2">
        <label for="email" class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Correo Electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          class="border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
          placeholder="ejemplo@correo.com"
          required>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-2">
          <label class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Contraseña</label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="pass"
              class="w-full border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
              placeholder="••••••••"
              required>
            <button type="button" onclick="togglePass('password', 'toggleText')" class="absolute inset-y-0 right-4 flex items-center text-[10px] font-bold text-orange-500 uppercase tracking-tighter">
              <span id="toggleText">Ver</span>
            </button>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label class="text-[10px] font-black uppercase text-gray-400 ml-1 tracking-widest">Confirmar</label>
          <div class="relative">
            <input
              type="password"
              id="passwordConfir"
              name="passConfir"
              class="w-full border-none bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 transition-all text-gray-700 font-medium"
              placeholder="••••••••"
              required>
            <button type="button" onclick="togglePass('passwordConfir', 'toggleTextConfir')" class="absolute inset-y-0 right-4 flex items-center text-[10px] font-bold text-orange-500 uppercase tracking-tighter">
              <span id="toggleTextConfir">Ver</span>
            </button>
          </div>
        </div>
      </div>

      <div class="mt-8 flex justify-end gap-3 pt-4">
        <button type="button" onclick="cerrarModal()" class="px-6 py-4 text-gray-400 font-bold hover:bg-gray-100 rounded-2xl transition-colors">
          Cancelar
        </button>
        <button type="submit" class="px-8 py-4 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all active:scale-95">
          Guardar Usuario
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function togglePass(inputId, textId) {
    const input = document.getElementById(inputId);
    const text = document.getElementById(textId);
    if (input.type === "password") {
      input.type = "text";
      text.innerText = "Ocultar";
    } else {
      input.type = "password";
      text.innerText = "Ver";
    }
  }
</script>