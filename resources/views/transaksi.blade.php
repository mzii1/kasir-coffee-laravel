<!-- resources/views/transaksi.blade.php -->
<x-app-layout title="Transaksi">
  <h2 class="text-2xl font-semibold mb-4 border-b pb-2 border-stone-300">Transaksi / Order Menu</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Menu List -->
    <div>
      <h3 class="text-xl font-semibold mb-2 text-brown-700">Pilih Menu</h3>
      <div class="space-y-4">
        @foreach ($menus as $menu)
          <div class="flex items-center justify-between p-4 bg-white shadow rounded-lg">
            <div class="flex flex-col">
              <span class="font-semibold text-lg text-brown-700">{{ $menu->nama }}</span>
              <span class="text-sm text-stone-500">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
            </div>
            
            <div class="flex items-center gap-2">
              <button type="button" class="qty-btn bg-stone-300 px-3 py-1 rounded" onclick="decreaseQty({{ $menu->id }})">−</button>
              <input type="number" id="qty-{{ $menu->id }}" value="0" min="0" class="w-14 text-center border border-stone-300 rounded" readonly />
              <button type="button" class="qty-btn bg-stone-300 px-3 py-1 rounded" onclick="increaseQty({{ $menu->id }})">+</button>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Order Summary -->
    <div>
      <h3 class="text-xl font-semibold mb-2 text-brown-700">Ringkasan Order</h3>
      <div id="order-summary" class="space-y-3">
        <p class="italic text-stone-500">Belum ada item.</p>
      </div>
      <div class="mt-4 font-semibold text-lg text-brown-800 text-right" id="order-total">
        Total: Rp 0
      </div>
      <div class="mt-4 flex gap-4">
        <button onclick="clearOrder()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-full">Clear</button>
        <button onclick="submitOrder()" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded w-full">Submit</button>
      </div>
    </div>
  </div>

  <script>
    let order = {};

    function increaseQty(id) {
      order[id] = (order[id] || 0) + 1;
      document.getElementById('qty-' + id).value = order[id];
      updateSummary();
    }

    function decreaseQty(id) {
      if (order[id]) {
        order[id]--;
        if (order[id] <= 0) {
          delete order[id];
        } else {
          document.getElementById('qty-' + id).value = order[id];
        }
        document.getElementById('qty-' + id).value = order[id] || 0;
        updateSummary();
      }
    }

    function updateSummary() {
      const summary = document.getElementById('order-summary');
      const totalBox = document.getElementById('order-total');
      summary.innerHTML = '';

      let total = 0;

      const menus = @json($menus);

      Object.keys(order).forEach(id => {
        const item = menus.find(m => m.id == id);
        if (item) {
          const qty = order[id];
          const subtotal = qty * item.harga;
          total += subtotal;

          const div = document.createElement('div');
          div.className = "flex justify-between items-center border-b pb-2";
          div.innerHTML = `
            <span>${item.nama} x${qty}</span>
            <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
          `;
          summary.appendChild(div);
        }
      });

      if (Object.keys(order).length === 0) {
        summary.innerHTML = '<p class="italic text-stone-500">Belum ada item.</p>';
      }

      totalBox.textContent = 'Total: Rp ' + total.toLocaleString('id-ID');
    }

    function clearOrder() {
      order = {};
      const inputs = document.querySelectorAll('input[id^="qty-"]');
      inputs.forEach(input => input.value = 0);
      updateSummary();
    }

    function submitOrder() {
      if (Object.keys(order).length === 0) {
        alert("Silakan pilih item terlebih dahulu.");
        return;
      }
      alert("Pesanan berhasil disubmit! (Simulasi)");
      clearOrder();
    }
  </script>
</x-app-layout>
