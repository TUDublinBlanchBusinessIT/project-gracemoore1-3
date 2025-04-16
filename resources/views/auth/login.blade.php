<x-guest-layout>
    {{-- Card container with a max‑width so it never overflows --}}
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
      
      {{-- Logo slot, now small and centered --}}
      <div class="mb-6 text-center">
        <img
          src="{{ asset('images/images.jpg') }}"
          alt="Bakery Logo"
          class="w-20 h-20 mx-auto"
        >
      </div>
      
      {{-- Session status & validation errors --}}
      <x-auth-session-status class="mb-4" :status="session('status')" />
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      
      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
          <x-label for="email" :value="__('Email')" />
          <x-input
            id="email"
            class="block mt-1 w-full"
            type="email"
            name="email"
            :value="old('email')"
            required
            autofocus
          />
        </div>

        {{-- Password --}}
        <div class="mb-4">
          <x-label for="password" :value="__('Password')" />
          <x-input
            id="password"
            class="block mt-1 w-full"
            type="password"
            name="password"
            required
            autocomplete="current-password"
          />
        </div>

        {{-- Remember Me --}}
        <div class="mb-6 flex items-center">
          <input
            id="remember_me"
            type="checkbox"
            name="remember"
            class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded"
          >
          <label for="remember_me" class="ml-2 block text-sm text-gray-700">
            {{ __('Remember me') }}
          </label>
        </div>

        {{-- Login Button --}}
        <div class="mb-6">
          <x-button class="w-full">
            {{ __('Log in') }}
          </x-button>
        </div>
      </form>
      
      {{-- Register link under the form --}}
      <p class="text-center text-sm text-gray-600">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}"
           class="font-medium text-yellow-700 hover:text-yellow-800 ml-1">
          {{ __('Register now!') }}
        </a>
      </p>
    </div>
</x-guest-layout>

