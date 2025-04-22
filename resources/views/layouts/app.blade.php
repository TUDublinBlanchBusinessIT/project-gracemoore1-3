<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <title>{{ config('app.name','My Bakery') }}</title>

  {{-- Quick Tailwind via CDN while we’re troubleshooting --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- When you’re ready, swap in your Vite build: --}}
  {{-- @vite(['resources/css/app.css','resources/js/app.js'])--}}
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-3xl md:max-w-4xl bg-amber-100 p-6 rounded-xl shadow-lg">
    @yield('content')
  </div>
</body>
</html>

