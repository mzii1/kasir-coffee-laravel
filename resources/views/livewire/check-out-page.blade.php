<div class="bg-white p-6 rounded shadow space-y-6">
    <h2 class="text-2xl font-bold">Checkout / Payment Menu</h2>

    <ul>
        @foreach ($keranjang as $item)
            <li class="flex justify-between border-b py-2">
                <span>{{ $item['nama'] }} ×{{ $item['jumlah'] }}</span>
                <span>Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
            </li>
        @endforeach
    </ul>

    <div class="text-right font-bold text-lg">Total: Rp{{ number_format($total, 0, ',', '.') }}</div>

    <div>
        <label class="block font-semibold mb-1">Payment Method</label>
        <select wire:model="metodePembayaran" class="w-full border rounded px-3 py-2">
            <option value="">Select payment method</option>
            <option value="cash">Bayar Cash</option>
            <option value="qris">Bayar QRIS</option>
        </select>
    </div>

    <button wire:click="konfirmasiPembayaran"
        class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">
        Konfirmasi Pembayaran
    </button>

    @if (session()->has('message'))
        <div class="mt-3 text-green-600 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    @if ($transaksiId)
        <a href="{{ route('struk.cetak', $transaksiId) }}" target="_blank"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-4 inline-block">
            Cetak Struk
        </a>
    @endif
</div>
