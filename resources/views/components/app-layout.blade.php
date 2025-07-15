<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* gray-100 */
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">
    <aside class="hidden md:block w-64 bg-white p-4 shadow-md">
        <h2 class="text-xl font-bold mb-6">Kasir App</h2>
        <nav class="space-y-2">
            <a href="/dashboard" class="block text-gray-700 hover:text-blue-600">Dashboard</a>
            <a href="/laporan" class="block text-gray-700 hover:text-blue-600">Laporan</a>
            <a href="/profil" class="block text-gray-700 hover:text-blue-600">Profil</a>
        </nav>
    </aside>

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $title ?? 'Dashboard' }}</h1>
        {{ $slot }}
    </main>
</body>
</html>
