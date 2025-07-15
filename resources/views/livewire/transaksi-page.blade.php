<div class="py-6 bg-zinc-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        {{-- Order Menu --}}
        <div>
            <h3 class="text-xl font-semibold text-brown-700 mb-4">Order Menu</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($menus as $menu)
                    <div class="bg-white shadow rounded-xl p-4 flex justify-between items-center">
                        {{-- Info Menu --}}
                        <div>
                            <h4 class="font-bold text-lg text-gray-800">{{ $menu->nama }}</h4>
                            <p class="text-sm text-gray-500">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Jumlah --}}
                        <div class="flex items-center space-x-2">
                            <button wire:click="kurang({{ $menu->id }})"
                                class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-lg font-bold">−</button>

                            <div class="w-8 text-center font-semibold">
                                {{ $keranjang[$menu->id]['jumlah'] ?? 0 }}
                            </div>

                            <button wire:click="tambah({{ $menu->id }})"
                                class="w-8 h-8 flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white rounded text-lg font-bold">+</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-brown-700 mb-4">Order Summary</h3>

            @forelse ($keranjang as $item)
                <div class="grid grid-cols-3 items-center text-gray-800 border-b pb-2">
                    <div class="font-semibold">
                        {{ $item['nama'] }}
                        
                    </div>
                    <div class="text-center">
                        x{{ $item['jumlah'] }}
                    </div>
                    <div class="text-right text-sm font-medium">
                        Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
                <!--<button wire:click="hapus({{ $item['id'] }})" class="text-red-600 hover:underline text-sm">
                    Hapus
                </button> -->
            @empty
                <p class="text-gray-500">Belum ada item.</p>
            @endforelse

            <div class="flex justify-between font-bold text-lg border-t mt-4">
                <span>  </span>
                <span>Total: Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <button wire:click="hapusKeranjang" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-md w-full">
                    Hapus
                </button>

                {{-- Arahkan ke Checkout --}}
                <form method="GET" action="{{ route('checkout') }}" class="w-full">
                    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 rounded-md">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
