@extends('layouts.app')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-4">Add New Customer</h2>

    <form action="{{ route('customers.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <x-label for="name" :value="__('Name')" />
        <x-input
          id="name"
          name="name"
          type="text"
          class="block mt-1 w-full"
          required
        />
      </div>

      <div class="mb-4">
        <x-label for="number" :value="__('Phone Number')" />
        <x-input
          id="number"
          name="number"
          type="text"
          class="block mt-1 w-full"
          required
        />
      </div>

      <x-button type="submit" class="w-full">Add Customer</x-button>
    </form>
  </div>
@endsection
