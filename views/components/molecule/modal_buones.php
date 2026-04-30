<div id="modalBonus" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm items-center justify-center z-50 p-4">

  <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl border border-gray-100 transform transition-all">

    <div class="flex items-center gap-4 mb-8">
      <div class="bg-orange-100 text-orange-500 p-3 rounded-2xl">
        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
      </div>
      <div>
        <h2 class="text-xl font-black text-gray-800 tracking-tight">Asignar Bonificación</h2>
        <p class="text-xs text-gray-400">Vincula un incentivo a un trabajador</p>
      </div>
    </div>

    <form action="../../app/controllers/assigBonus.php" method="POST" class="space-y-6">

      <div>
        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Seleccionar Trabajador</label>
        <div class="relative">
          <select name="id_user" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-700 font-medium focus:ring-2 focus:ring-orange-500 appearance-none transition-all">
            <option value="" disabled selected>Elige un empleado...</option>
            <?php foreach ($personal as $u): ?>
              <option value="<?= $u['id_usuario'] ?>"><?= $u['name'] . " " . $u['last_name'] ?> (<?= $u['dni'] ?>)</option>
            <?php endforeach; ?>
          </select>
          <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-chevron-down text-xs"></i>
          </div>
        </div>
      </div>

      <div>
        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Tipo de Bono</label>
        <div class="relative">
          <select name="id_bonus" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-700 font-medium focus:ring-2 focus:ring-orange-500 appearance-none transition-all">
            <option value="" disabled selected>Elige el beneficio...</option>
            <?php
            $bonusList = $userModel->getAvailableBonuses();
            foreach ($bonusList as $b):
            ?>
              <option value="<?= $b['id'] ?>"><?= $b['name_bonuses'] ?> - $<?= number_format($b['amount'], 2) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-gift text-xs"></i>
          </div>
        </div>
      </div>

      <div class="flex gap-3 pt-4">
        <button type="button" onclick="closeBonus()" class="flex-1 py-4 rounded-2xl text-gray-400 font-bold hover:bg-gray-100 transition-colors cursor-pointer">
          Cancelar
        </button>
        <button type="submit" class="flex-1 py-4 bg-orange-500 text-white rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all active:scale-95 cursor-pointer">
          Confirmar
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function closeBonus() {
    const modal = document.getElementById('modalBonus');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>