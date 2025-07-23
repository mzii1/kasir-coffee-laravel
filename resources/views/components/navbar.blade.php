@php
  $role = auth()->user()->role;

  $tabs = match($role) {
    'admin' => [
      'dashboard' => 'Dashboard',
      'transaksi' => 'Transaksi',
      'checkout' => 'Checkout',
      'laporan' => 'Laporan',
      'profile' => 'Profil'
    ],
    'kasir' => [
      'transaksi' => 'Transaksi',
      'checkout' => 'Checkout',
      'profile' => 'Profil'
    ],
    default => [
      'profile' => 'Profil'
    ],
  };

  $current = request()->segment(1);
@endphp

<nav class="bg-brown-600 flex shadow-inner overflow-x-auto">
  @foreach($tabs as $route => $label)
    <a href="{{ url($route) }}"
       class="flex-1 min-w-[120px] text-center py-3 px-4 font-semibold text-stone-200 border-b-4 transition
              {{ $current === $route ? 'bg-brown-700 border-white text-white' : 'hover:bg-brown-700 border-transparent' }}">
      {{ $label }}
    </a>
  @endforeach
</nav>
