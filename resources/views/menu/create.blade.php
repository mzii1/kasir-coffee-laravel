<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Menu
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block font-semibold mb-1">Nama Menu</label>
                <input type="text" name="nama" id="nama" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="kategori" class="block font-semibold mb-1">Kategori</label>
                <select name="kategori" id="kategori" class="w-full border rounded p-2" required>
                    <option value="kopi">Kopi</option>
                    <option value="non_kopi">Non Kopi</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="harga" class="block font-semibold mb-1">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block font-semibold mb-1">Gambar Menu</label>
                <input type="file" name="gambar" id="gambar" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
