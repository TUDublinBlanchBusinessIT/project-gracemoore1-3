<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','My Bakery') }}</title>

  {{-- load Tailwind + your JS --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-amber-50 flex items-center justify-center min-h-screen font-sans">
  @yield('content')
</body>
</html>
