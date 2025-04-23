@extends('layouts.app')

@section('content')
  <h1 class="text-3xl font-bold mb-6">Customer Information</h1>

  <form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label class="font-medium">Select Existing Customer</label>
      <select name="customer_id"
              class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">— New Customer —</option>
        @foreach(\App\Models\Customer::all() as $c)
          <option value="{{ $c->id }}">
            {{ $c->name }} ({{ $c->number }})
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="font-medium">Name</label>
      <input type="text" name="name"
             class="mt-1 block w-full border rounded px-3 py-2"
             value="{{ old('name') }}">
    </div>

    <div class="mb-4">
      <label class="font-medium">Phone</label>
      <input type="text" name="number"
             class="mt-1 block w-full border rounded px-3 py-2"
             value="{{ old('number') }}">
    </div>

    <button type="submit"
            class="bg-yellow-700 text-white px-6 py-2 rounded hover:bg-yellow-800">
      Submit Order
    </button>
  </form>
@endsection
