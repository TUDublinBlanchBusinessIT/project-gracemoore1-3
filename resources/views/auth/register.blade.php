{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="mb-6 text-center">
    <img src="{{ asset('images/images.jpg') }}"
         alt="Logo"
         class="w-20 h-20 mx-auto" />
  </div>

  <x-auth-validation-errors class="mb-4" :errors="$errors" />

  <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div class="mb-4">
      <x-label for="name" :value="__('Name')" />
      <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus/>
    </div>

    {{-- Email --}}
    <div class="mb-4">
      <x-label for="email" :value="__('Email')" />
      <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
    </div>

    {{-- Password --}}
    <div class="mb-4">
      <x-label for="password" :value="__('Password')" />
      <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
    </div>

    {{-- Confirm Password --}}
    <div class="mb-6">
      <x-label for="password_confirmation" :value="__('Confirm Password')" />
      <x-input id="password_confirmation" class="block mt-1 w-full"
               type="password"
               name="password_confirmation" required />
    </div>

    <div class="flex items-center justify-end">
      <x-button class="w-full">
        {{ __('Register') }}
      </x-button>
    </div>
  </form>
@endsection
