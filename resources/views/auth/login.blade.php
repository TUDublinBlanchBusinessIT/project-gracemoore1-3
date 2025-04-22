@extends('layouts.app')

@section('content')
  <div class="mb-6 text-center">
    <img src="{{ asset('images/images.jpg') }}"
         alt="Bakery Logo"
         class="w-20 h-20 mx-auto" />
  </div>

  {{-- Session status & Validation --}}
  <x-auth-session-status class="mb-4" :status="session('status')" />
  <x-auth-validation-errors class="mb-4" :errors="$errors" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
      <x-label for="email" :value="__('Email')" />
      <x-input id="email"
               class="block mt-1 w-full"
               type="email"
               name="email"
               :value="old('email')"
               required autofocus />
    </div>

    <div class="mb-4">
      <x-label for="password" :value="__('Password')" />
      <x-input id="password"
               class="block mt-1 w-full"
               type="password"
               name="password"
               required autocomplete="current-password" />
    </div>

    <div class="mb-4 flex items-center">
      <input id="remember_me"
             type="checkbox"
             name="remember"
             class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring focus:ring-yellow-200 focus:ring-opacity-50" />
      <label for="remember_me" class="ml-2 text-sm text-gray-700">
        {{ __('Remember me') }}
      </label>
    </div>

    <div class="mb-6">
      <x-button class="w-full">
        {{ __('Log in') }}
      </x-button>
    </div>
  </form>

  <p class="text-center text-sm text-gray-700">
    {{ __("Don't have an account?") }}
    <a href="{{ route('register') }}"
       class="font-medium text-yellow-700 hover:text-yellow-800 ml-1">
      {{ __('Register now!') }}
    </a>
  </p>
@endsection
