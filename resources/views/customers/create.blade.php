{{-- resources/views/customers/create.blade.php --}}
@extends('layouts.app')

@section('content')
  {{-- Title, centered --}}
  <div class="text-center mb-6">
    <h1 class="text-3xl font-bold">Add New Customer</h1>
  </div>

  {{-- Form (no extra inner box) --}}
  <form action="{{ route('customers.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label for="name" class="block text-sm font-medium mb-1">Name</label>
      <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name') }}"
        required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-yellow-300"
      >
    </div>

    <div>
      <label for="number" class="block text-sm font-medium mb-1">Phone Number</label>
      <input
        type="text"
        name="number"
        id="number"
        value="{{ old('number') }}"
        required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-yellow-300"
      >
    </div>

    <div class="flex justify-center">
      <button
        type="submit"
        class="px-6 py-3 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800"
      >
        Save Customer
      </button>
    </div>
  </form>
@endsection




