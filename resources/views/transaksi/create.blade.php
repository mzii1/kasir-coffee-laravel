<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <table id="menu-table" class="w-full mb-4 border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">Menu</th>
                        <th class="p-2">Jumlah</th>
                        <th class="p-2">
                            <button type="button" onclick="addRow()" class="bg-blue-500 text-white px-2 py-1 rounded">Tambah</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="menu-row">
                        <td class="p-2">
                            <select name="menu_id[]" class="w-full border rounded">
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" data-harga="{{ $menu->harga}}">
                                        {{ $menu->nama }} - Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-2">
                            <input type="number" name="jumlah" id="total" required class="w-full border rounded px-2 py-1" readonly>
                        </td>
                        <td class="p-2 text-center">
                            <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mb-4">
                <label class="block font-medium">Total (isi manual dulu untuk awal):</label>
                <input type="number" name="total" required class="w-full border rounded px-2 py-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Metode Pembayaran:</label>
                <select name="metode_pembayaran" class="w-full border rounded px-2 py-1">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Transaksi</button>
        </form>
    </div>

    <script>
        function addRow() {
            const tableBody = document.querySelector('#menu-table tbody');
            const firstRow = tableBody.querySelector('.menu-row');
            const newRow = firstRow.cloneNode(true);

            // Reset input values
            newRow.querySelector('select').selectedIndex = 0;
            newRow.querySelector('input[name="jumlah[]"]').value = 1;

            // Tambahkan event listener ke elemen baru
            newRow.querySelector('select').addEventListener('change', calculateTotal);
            newRow.querySelector('input[name="jumlah[]"]').addEventListener('input', calculateTotal);

            tableBody.appendChild(newRow);
            calculateTotal();
        }

        function removeRow(button) {
            const tableBody = document.querySelector('#menu-table tbody');
            if (tableBody.querySelectorAll('.menu-row').length > 1) {
                button.closest('tr').remove();
            }
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.menu-row').forEach(row => {
                const select = row.querySelector('select');
                const jumlah = parseInt(row.querySelector('input[name="jumlah[]"]').value) || 0;
                const harga = parseInt(select.options[select.selectedIndex].getAttribute('data-harga')) || 0;
                total += jumlah * harga;
            });

            document.getElementById('total').value = total;
        }

        // Pasang event listener awal
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.menu-row select').forEach(select => {
                select.addEventListener('change', calculateTotal);
            });

            document.querySelectorAll('.menu-row input[name="jumlah[]"]').forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            calculateTotal(); // Hitung saat awal
        });
    </script>
</x-app-layout>
