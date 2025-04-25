@extends('layouts.app')

@section('content')
  <h1 class="text-3xl font-bold mb-6">Customer Information</h1>
@if($errors->any())
  <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
    <ul class="list-disc pl-5">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

  <form action="{{ route('orders.store') }}" method="POST">
    @csrf

    {{-- Existing customer dropdown --}}
    <div class="mb-4">
      <label class="font-medium">Select Existing Customer</label>
      <select name="customer_id"
              class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">— New Customer —</option>
        @foreach($customers as $c)
          <option value="{{ $c->id }}" {{ old('customer_id')==$c->id ? 'selected':'' }}>
            {{ $c->name }} ({{ $c->number }})
          </option>
        @endforeach
      </select>
    </div>

    {{-- New name/phone (only if no existing selected) --}}
    <div class="mb-4">
      <label class="font-medium">Name</label>
      <input type="text" name="name"
             value="{{ old('name') }}"
             placeholder="Customer name"
             class="mt-1 block w-full border rounded px-3 py-2">
    </div>
    <div class="mb-4">
      <label class="font-medium">Phone Number</label>
      <input type="text" name="number"
             value="{{ old('number') }}"
             placeholder="Customer phone"
             class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    {{-- Pick-up date/time --}}
    <div class="mb-6">
      <label class="font-medium">Pick-up Date & Time</label>
      <input type="datetime-local" name="pickup_datetime"
             value="{{ old('pickup_datetime',$pickupDateTime) }}"
             class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    {{-- Continue browsing & submit --}}
    <div class="flex justify-between items-center">
      <a href="{{ route('items.index') }}"
         class="text-gray-700 hover:underline">
        ← Continue Browsing
      </a>
      <button type="submit"
              class="bg-yellow-700 text-white px-6 py-2 rounded hover:bg-yellow-800">
        Submit Order
      </button>
    </div>
  </form>
@endsection



