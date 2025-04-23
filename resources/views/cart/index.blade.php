@extends('layouts.app')

@section('content')
  <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  @if(empty($cart))
    <p>Your cart is empty.</p>
  @else
    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr class="text-center">
            <th class="px-6 py-3">Item</th>
            <th class="px-6 py-3">Qty</th>
            <th class="px-6 py-3">Price</th>
            <th class="px-6 py-3">Edit</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach($cart as $id => $line)
            <tr class="text-center">
              <td class="px-6 py-4">{{ $line['name'] }}</td>
              <td class="px-6 py-4">{{ $line['quantity'] }}</td>
              <td class="px-6 py-4">
                ${{ number_format($line['price'] * $line['quantity'],2) }}
              </td>
              <td class="px-6 py-4 space-x-2">
                {{-- update quantity --}}
                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                  @csrf @method('PATCH')
                  <input type="number" name="quantity"
                         value="{{ $line['quantity'] }}"
                         min="1"
                         class="w-16 text-center border rounded px-1">
                  <button type="submit"
                          class="ml-1 bg-blue-600 text-white px-2 py-1 rounded">
                    Save
                  </button>
                </form>
                {{-- remove --}}
                <form action="{{ route('cart.destroy', $id) }}" method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="ml-1 bg-red-500 text-white px-2 py-1 rounded">
                    Remove
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- total + next + continue --}}
    <div class="mt-6 flex justify-between items-start">
      {{-- Total --}}
      <div class="text-xl font-semibold">
        Total: ${{ number_format($total,2) }}
      </div>

      {{-- Next & Continue --}}
      <div class="flex flex-col items-end space-y-2">
        <a href="{{ route('orders.create') }}"
           class="bg-yellow-700 text-white px-6 py-2 rounded hover:bg-yellow-800">
          Next: Customer Info →
        </a>
        <a href="{{ route('items.index') }}"
           class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
          ← Continue Browsing
        </a>
      </div>
    </div>
  @endif
@endsection


