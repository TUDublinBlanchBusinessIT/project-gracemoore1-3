@extends('layouts.app')

@section('content')
  <div class="w-full max-w-md bg-yellow-50 p-8 rounded-2xl shadow-lg mt-12">
    
    <h1 class="text-2xl font-bold text-center mb-6">Add New Customer</h1>

    {{-- Validation errors --}}
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('customers.store') }}">
      @csrf

      <div class="mb-4">
        <x-label for="name" :value="__('Name')" />
        <x-input id="name"
                 class="block mt-1 w-full"
                 type="text"
                 name="name"
                 :value="old('name')"
                 required
        />
      </div>

      <div class="mb-4">
        <x-label for="number" :value="__('Phone Number')" />
        <x-input id="number"
                 class="block mt-1 w-full"
                 type="text"
                 name="number"
                 :value="old('number')"
                 required
        />
      </div>

      <div class="flex justify-center mt-6">
        <x-button>
          {{ __('Save Customer') }}
        </x-button>
      </div>
    </form>
  </div>
@endsection



