<!-- resources/views/components/app-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Coffee Cashier' }}</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Livewire Styles -->
  @livewireStyles
</head>
<body class="bg-gradient-to-br from-stone-600 to-stone-300 min-h-screen text-brown-900 font-sans">

  <header class="bg-brown-700 text-white py-6 text-center font-semibold text-2xl shadow-lg">
    Coffee Cashier
  </header>

  <x-navbar />

  <main class="container mx-auto px-4 py-8">
    {{ $slot }}
  </main>

  <!-- Livewire Scripts HARUS di dalam body -->
  @livewireScripts

</body>
</html>
