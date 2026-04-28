<div id="modalCrearUsuario" class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm items-center justify-center">

  <div class="bg-white w-full max-w-lg mx-4 rounded-xl shadow-2xl transform transition-all">

    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
      <h2 class="text-xl font-bold text-orange-500">Crear Usuario - Nominy</h2>
      <button onclick="cerrarModal()" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
    </div>

    <form action="../../app/controllers/userControll.php" method="POST" class="p-6 space-y-5">
      <input type="hidden" name="action" value="register">
      <input type="hidden" name="origen" value="rrhh">
      <div class="flex flex-col gap-2">
        <label for="dni" class="font-semibold text-gray-700">Docuemento de identidad</label>
        <input
          type="dni"
          id="dni"
          name="dni"
          class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
          placeholder="V-24165273"
          required>
      </div>
      <!-- nombre y apellido -->
      <div class="grid grid-cols-2 gap-2">
        <div class="flex flex-col gap-2">
          <label for="name" class="font-semibold text-gray-700">Nombre</label>
          <input
            type="text"
            id="name"
            name="name"
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
            placeholder="Juan"
            required>
        </div>
        <div class="flex flex-col gap-2">
          <label for="lastName" class="font-semibold text-gray-700">Apellido</label>
          <input
            type="text"
            id="lastName"
            name="lastName"
            class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
            placeholder="Fernandez"
            required>
        </div>
      </div>

      <div class="flex flex-col gap-2">
        <label for="userName" class="font-semibold text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all"
          placeholder="ejemplo@correo.com"
          required>
      </div>

      <div class="grid grid-cols-2 gap-2">

        <div class="flex flex-col gap-2 relative">
          <label for="password" class="font-semibold text-gray-700">Contraseña</label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="pass"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400 transition-all w-full"
              placeholder="••••••••"
              required>

            <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-orange-500 font-bold">
              <span id="toggleText">Mostrar</span>
            </button>
          </div>
        </div>

        <div class="flex flex-col gap-2 relative">
          <label for="password" class="font-semibold text-gray-700">Confirma</label>
          <div class="relative">
            <input
              type="password"
              id="passwordConfir"
              name="passConfir"
              class="border border-gray-300 p-3 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-orange-400  transition-all w-full"
              placeholder="••••••••"
              required>
            <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-orange-500 font-bold">
              <span id="toggleTextConfir">Mostrar</span>
            </button>
          </div>
        </div>
      </div>
      <div class="mt-6 flex justify-end gap-3">
        <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-200 rounded">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded shadow">Guardar</button>
      </div>
    </form>
  </div>
</div>