@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Edit Customer</h1>

  <form action="{{ route('customers.update', $customer) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium">Name</label>
      <input type="text"
             name="name"
             value="{{ old('name', $customer->name) }}"
             class="mt-1 block w-full rounded border-gray-300"
             required>
    </div>

    <div>
      <label class="block text-sm font-medium">Phone</label>
      <input type="text"
             name="number"
             value="{{ old('number', $customer->number) }}"
             class="mt-1 block w-full rounded border-gray-300"
             required>
    </div>

    <div class="flex space-x-2">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Update
      </button>
      <a href="{{ route('customers.index') }}"
         class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
        Cancel
      </a>
    </div>
  </form>
@endsection
