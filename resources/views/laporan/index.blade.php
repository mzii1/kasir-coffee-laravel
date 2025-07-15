<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Penjualan
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label>Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="border rounded w-full p-2">
                </div>
                <div>
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="border rounded w-full p-2">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Filter</button>
                    <a href="{{ route('laporan.exportPdf', request()->all()) }}" 
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        📄 Export PDF
                    </a>
                    <a href="{{ route('laporan.exportExcel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        📄 Export Excel
                    </a>

                </div>
            </div>
        </form>

        @if (count($transaksis) > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 text-left">Tanggal</th>
                            <th class="p-2 text-left">Metode</th>
                            <th class="p-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $t)
                            <tr>
                                <td class="p-2">{{ $t->tanggal }}</td>
                                <td class="p-2">{{ $t->metode_pembayaran }}</td>
                                <td class="p-2">Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif(request()->filled('tanggal_awal'))
            <p class="text-gray-500 mt-4">Tidak ada transaksi pada rentang tanggal tersebut.</p>
        @endif
    </div>
</x-app-layout>
