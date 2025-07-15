<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Menu
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block font-semibold mb-1">Nama Menu</label>
                <input type="text" name="nama" id="nama" class="w-full border rounded p-2" value="{{ $menu->nama }}" required>
            </div>

            <div class="mb-4">
                <label for="kategori" class="block font-semibold mb-1">Kategori</label>
                <select name="kategori" id="kategori" class="w-full border rounded p-2" required>
                    <option value="kopi" {{ $menu->kategori == 'kopi' ? 'selected' : '' }}>Kopi</option>
                    <option value="non_kopi" {{ $menu->kategori == 'non_kopi' ? 'selected' : '' }}>Non Kopi</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="harga" class="block font-semibold mb-1">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full border rounded p-2" value="{{ $menu->harga }}" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block font-semibold mb-1">Gambar Menu</label>
                <input type="file" name="gambar" id="gambar" class="w-full border rounded p-2">
                @if ($menu->gambar)
                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="mt-2 w-32 rounded">
                @endif
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
