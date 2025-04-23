<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','My Bakery') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen flex flex-col">

  {{-- only show nav when logged in --}}
  @auth
    <nav class="bg-yellow-700 text-white px-6 py-4 flex justify-between items-center">
      <ul class="flex space-x-6">
        <li><a href="{{ route('items.index') }}" class="hover:underline">Our Bakery</a></li>
        <li><a href="{{ route('orders.index') }}" class="hover:underline">Orders</a></li>
        <li><a href="{{ route('employees.index') }}" class="hover:underline">Employees</a></li>
        <li><a href="{{ route('customers.index') }}" class="hover:underline">Customers</a></li>
        <li><a href="{{ route('completed_orders.index') }}" class="hover:underline">Completed Orders</a></li>
      </ul>

      <div class="flex items-center space-x-6">
        {{-- cart badge --}}
        <a href="{{ route('cart.index') }}"
           class="relative hover:opacity-75">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-6 w-6 text-white"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M16 21a2 2 0 11-4 0M8 21a2 2 0 11-4 0"/>
          </svg>
          @php
            $count = array_sum(session('cart',[])) 
                    ? array_sum(array_column(session('cart'),'quantity')) 
                    : 0;
          @endphp
          @if($count)
            <span class="absolute -top-1 -right-2 bg-red-600 text-xs text-white rounded-full px-1">
              {{ $count }}
            </span>
          @endif
        </a>

        {{-- user dropdown + focus-within so it stays open when you move to it --}}
        <div class="relative" tabindex="0">
          <button class="focus:outline-none">
            <img src="{{ asset('icons/user-icon.png') }}"
                 alt="User"
                 class="h-6 w-6 rounded-full">
          </button>
          <div class="hidden focus-within:block absolute right-0 mt-2 w-32 bg-white text-gray-800 rounded shadow-lg">
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
  @endauth

  <main class="flex-grow container mx-auto px-6 py-8 max-w-6xl">
    @yield('content')
  </main>
</body>
</html>




