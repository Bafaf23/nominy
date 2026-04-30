<div id="modalPagoIndividual" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm items-center justify-center z-50 p-4">
  <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">

    <!-- Header -->
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-slate-900 text-white">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-hand-holding-dollar text-orange-500 text-xl"></i>
        <h2 class="text-lg font-black" id="pagoNombreEmpleado">Pago Individual</h2>
      </div>
      <button onclick="cerrarModalPago()" class="text-slate-400 hover:text-white transition-colors text-2xl">&times;</button>
    </div>

    <form action="../../app/controllers/payrollControll.php" method="POST" class="p-8 space-y-4">
      <input type="hidden" name="action" value="process_single_payroll">
      <input type="hidden" name="id_user" id="pagoIdUser">
      <input type="hidden" name="amount" id="pagoMontoTotalOculto">

      <!-- Inputs para Deducciones de Ley (Venezuela) -->
      <input type="hidden" name="sso" id="hiddenSSO">
      <input type="hidden" name="spf" id="hiddenSPF">
      <input type="hidden" name="faov" id="hiddenFAOV">

      <!-- Desglose Visual -->
      <div class="bg-gray-50 p-5 rounded-3xl space-y-3 border border-gray-100">
        <div class="flex justify-between text-xs font-bold">
          <span class="text-gray-400 uppercase tracking-widest">Ingresos Totales</span>
          <span class="text-gray-700" id="displayIngresos">$0.00</span>
        </div>
        <div class="flex justify-between text-xs font-bold">
          <span class="text-red-400 uppercase tracking-widest">Retenciones Ley (5.5%)</span>
          <span class="text-red-600" id="displayDeducciones">-$0.00</span>
        </div>
        <hr class="border-dashed border-gray-200">
        <div class="flex justify-between items-center pt-1">
          <span class="text-slate-900 font-black">Neto a Pagar</span>
          <span class="text-2xl font-black text-orange-600" id="displayTotal">$0.00</span>
        </div>
      </div>

      <div class="flex flex-col gap-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Periodo Correspondiente</label>
        <input type="text" name="periodo" value="<?= date('F Y') ?>"
          class="bg-gray-50 border-none p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 font-bold text-gray-700">
      </div>

      <div class="flex flex-col gap-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Banco Emisor</label>
        <select name="bank" class="bg-gray-50 border-none p-4 rounded-2xl outline-none focus:ring-2 focus:ring-orange-400 font-bold text-gray-700">
          <option value="BBVA Provincial">BBVA Provincial</option>
          <option value="Pago Móvil">Pago Móvil</option>
          <option value="Banco de Venezuela">Banco de Venezuela</option>
        </select>
      </div>

      <div class="flex flex-col gap-2 pt-4">
        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-orange-600 transition-all active:scale-95">
          Confirmar Pago
        </button>
        <button type="button" onclick="cerrarModalPago()" class="w-full py-3 text-gray-400 font-bold hover:bg-gray-100 rounded-2xl transition-colors">
          Cancelar
        </button>
      </div>
    </form>
  </div>
</div>