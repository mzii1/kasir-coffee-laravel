<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl items-center font-semibold">Daftar Menu</h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Menu</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if ($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="x-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-300 flex items-center justify-center text-gray-600">Tidak ada gambar</div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-lg font-semibold">{{ $menu->nama }}</h2>
                        <p class="text-gray-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                
            @endforeach
        </div>
    </div>
</x-app-layout>
