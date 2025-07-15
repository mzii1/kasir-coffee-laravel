<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Ringkasan Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white shadow rounded-xl p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-600">Total Transaksi</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalTransaksi }}</p>
                    <p class="text-sm text-gray-400">Per hari ini</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-600">Menu Tersedia</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalMenu }}</p>
                    <p class="text-sm text-gray-400">Produk yang siap dijual</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-600">Transaksi Hari Ini</h3>
                    <p class="text-3xl font-bold text-orange-500">{{ $transaksiHariIni }}</p>
                    <p class="text-sm text-gray-400">Jumlah transaksi hari ini</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-600">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalUser }}</p>
                    <p class="text-sm text-gray-400">Pengguna terdaftar</p>
                </div>
            </div>

            {{-- Statistik Mingguan --}}
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Transaksi Mingguan</h3>
                {{-- Nanti disini tempat Chart --}}
                <canvas id="transaksiChart" height="120"></canvas>
            </div>

        </div>
    </div>
</x-app-layout>
