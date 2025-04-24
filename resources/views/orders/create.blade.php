@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-amber-100 p-6 rounded-lg shadow-lg">
  <h1 class="text-2xl font-bold mb-4 text-center">Customer Information</h1>

  {{-- Display validation errors --}}
  @if ($errors->any())
    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('orders.store') }}" method="POST">
    @csrf

    {{-- Existing customer --}}
    <div class="mb-4">
      <label for="customer_id" class="block font-medium mb-1">
        Select Existing Customer
      </label>
      <select id="customer_id"
              name="customer_id"
              class="mt-1 block w-full border-gray-300 rounded px-3 py-2">
        <option value="">— New Customer —</option>
        @foreach($customers as $c)
          <option value="{{ $c->id }}"
           {{ old('customer_id') == $c->id ? 'selected' : '' }}>
            {{ $c->name }} ({{ $c->number }})
          </option>
        @endforeach
      </select>
    </div>

    {{-- Name --}}
    <div class="mb-4">
      <label for="name" class="block font-medium mb-1">Name</label>
      <input id="name"
             type="text"
             name="name"
             value="{{ old('name') }}"
             placeholder="Customer name"
             class="mt-1 block w-full border-gray-300 rounded px-3 py-2">
    </div>

    {{-- Phone --}}
    <div class="mb-6">
      <label for="number" class="block font-medium mb-1">Phone Number</label>
      <input id="number"
             type="text"
             name="number"
             value="{{ old('number') }}"
             placeholder="Customer phone"
             class="mt-1 block w-full border-gray-300 rounded px-3 py-2">
    </div>

    <div class="mb-4">
      <label class="font-medium">Pick-up Date & Time</label>
      <input
            type="datetime-local"
            name="pickup_datetime"
            value="{{ old('pickup_datetime') }}"
            class="mt-1 block w-full border rounded px-3 py-2"
            required
        >
    </div>

    {{-- Buttons --}}
    <div class="flex justify-between items-center">
      <a href="{{ route('items.index') }}"
         class="underline text-gray-700 hover:text-gray-900">
        ← Continue Browsing
      </a>
      <button type="submit"
              class="bg-yellow-700 text-white px-6 py-2 rounded hover:bg-yellow-800">
        Submit Order
      </button>
    </div>
  </form>
</div>
@endsection


