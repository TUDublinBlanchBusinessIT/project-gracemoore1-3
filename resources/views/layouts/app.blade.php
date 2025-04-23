<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','My Bakery') }}</title>

  {{-- Tailwind via CDN for now --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen flex flex-col">

  {{-- NAV BAR --}}
  <nav class="bg-yellow-700 text-white px-6 py-4 flex justify-between items-center">
    <ul class="flex space-x-6">
      <li><a href="{{ route('items.index') }}" class="hover:underline">Our Bakery</a></li>
      <li><a href="{{ route('orders.index') ?? '#' }}" class="hover:underline">Orders</a></li>
      <li><a href="{{ route('employees.index') ?? '#' }}" class="hover:underline">Employees</a></li>
      <li><a href="{{ route('customers.index') }}" class="hover:underline">Customers</a></li>
      <li><a href="{{ route('completed_orders.index') ?? '#' }}" class="hover:underline">Completed Orders</a></li>
    </ul>

    <div class="flex items-center space-x-4">
      {{-- Shopping cart icon --}}
      <a href="{{ route('cart.index') ?? '#' }}" class="relative">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 text-white"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M16 21a2 2 0 11-4 0M8 21a2 2 0 11-4 0"/>
        </svg>
        {{-- optional badge: --}}
        {{-- <span class="absolute -top-1 -right-1 bg-red-600 text-xs text-white rounded-full px-1">
          {{ Cart::count() }}
        </span> --}}
      </a>

      {{-- User dropdown via group-hover --}}
      <div class="relative group">
        <button>
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-6 w-6 text-white"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A7 7 0 0112 15h0a7 7 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </button>
        <div class="hidden group-hover:block absolute right-0 mt-2 w-32 bg-white text-gray-800 rounded shadow-lg">
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
             class="block px-4 py-2 hover:bg-gray-100">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </nav>

  {{-- MAIN CONTENT WRAPPER (wider) --}}
  <main class="flex-grow container mx-auto px-6 py-8 max-w-6xl">
    @yield('content')
  </main>
</body>
</html>


