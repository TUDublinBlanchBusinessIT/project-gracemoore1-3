@extends('layouts.app')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Our Bakery</h1>
    <a href="{{ route('items.create') }}"
       class="bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-800">
      Add New Item
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-6 text-center">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($items as $item)
      <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
        <a href="{{ route('items.show', $item) }}">
          <!-- ← NOW points to public/images -->
          <img
            src="{{ asset('images/'.$item->image) }}"
            alt="{{ $item->name }}"
            class="w-full h-40 object-cover"
          >
        </a>
        <div class="p-4 flex flex-col">
          <h2 class="font-semibold text-lg mb-1">{{ $item->name }}</h2>
          <p class="text-gray-600 mb-4">${{ number_format($item->price,2) }}</p>

          <form action="{{ route('cart.add', $item) }}"
                method="POST"
                class="mt-auto">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button
              type="submit"
              class="w-full bg-yellow-700 text-white py-2 rounded hover:bg-yellow-800"
            >Add to Cart</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
@endsection

