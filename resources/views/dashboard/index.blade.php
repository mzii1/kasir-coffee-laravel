<x-app-layout>
    <div class="min-h-screen bg-gray-100" x-data="{open: false}">
        {{-- Navbar --}}
        <div class="max-w-7xl mx-auto px-4 py-4">
            <header class="bg-white shadow px-4 py-3 rounded-lg">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg md:text-xl font-bold text-gray-700">Dashboard</h1>
                    
                    <!-- Tombol Hamburger (hanya di mobile) -->
                    <button @click="open = !open" class="md:hidden text-gray-600 hover:text-indigo-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </header>
        </div>

        {{-- Content --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            {{-- Ringkasan --}}
            <div class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-gray-500">TOTAL TRANSAKSI</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-indigo-600">{{ number_format($totalTransaksi ?? 0) }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Per hari ini</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-gray-500">MENU TERSEDIA</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-indigo-600">{{ $totalMenu ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Produk yang siap dijual</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-gray-500">TRANSAKSI HARI INI</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-indigo-600">{{ $transaksiHariIni ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Jumlah transaksi hari ini</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-gray-500">TOTAL PENGGUNA</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-indigo-600">{{ $totalUser ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Pengguna terdaftar</p>
                </div>
            </div>

            {{-- Grafik Transaksi --}}
            <div style="height: 500px;" class="bg-white rounded-xl shadow p-6 overflow-x-auto">
                <h3 class="text-base md:text-lg font-semibold text-gray-700 mb-4">Statistik Transaksi Mingguan</h3>
                <canvas id="penjualanChart" class="w-full"></canvas>
            </div>
        </main>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('penjualanChart').getContext('2d');

            const data = {
                labels: @json($penjualan->pluck('tanggal')),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: @json($penjualan->pluck('total')),
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
</x-app-layout>
