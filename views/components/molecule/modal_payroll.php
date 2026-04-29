<div id="modalPay" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">

  <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">

    <div class="bg-orange-500 p-8 flex flex-col items-center text-white">
      <div class="bg-white/20 p-4 rounded-3xl mb-4">
        <i class="fa-solid fa-money-bill-transfer text-4xl"></i>
      </div>
      <h2 class="text-2xl font-bold">Procesar Nómina</h2>
      <p class="text-orange-100 text-sm">Confirmación de pago masivo</p>
    </div>

    <form action="../../app/controllers/processPayroll.php" method="POST" class="p-8">
      <div class="space-y-6">

        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
          <div>
            <p class="text-xs text-gray-400 font-bold uppercase">Periodo actual</p>
            <p class="text-gray-700 font-bold">1ra Quincena Abril 2026</p>
          </div>
          <i class="fa-solid fa-calendar-day text-orange-400 text-xl"></i>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="p-4 border border-gray-100 rounded-2xl">
            <p class="text-[10px] text-gray-400 font-bold uppercase">Empleados</p>
            <input type="text" class="text-xl font-black text-gray-800 outline-none" id="totalPersonal" readonly />
          </div>
          <div class="p-4 border border-gray-100 rounded-2xl">
            <p class="text-[10px] text-gray-400 font-bold uppercase">Total a Pagar</p>
            <input type="text" class="text-xl font-black text-green-600 outline-none" id="totalSalaryDisplay" readonly />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Comentario de referencia</p>
            <input type="text" name="reference" placeholder="Ej: Pago quincenal abril"
              class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-400 transition-all">
        </div>
      </div>

      <div class="flex gap-3 mt-8">
        <button type="button" onclick="closePayroll()"
          class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-50 rounded-2xl transition-all">
          Cancelar
        </button>
        <button type="submit"
          class="flex-1 py-3 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all">
          Confirmar Pago
        </button>
      </div>
    </form>
  </div>
</div>