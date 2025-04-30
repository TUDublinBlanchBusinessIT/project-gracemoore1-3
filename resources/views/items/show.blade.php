@extends('layouts.app')

@section('content')
    <div class="max-w‑2xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold">{{ $item->name }}</h1>
            <p class="text-gray-600">${{ number_format($item->price,2) }}</p>
        </div>

        <img
            src="{{ asset('images/'.$item->image) }}"
            alt="{{ $item->name }}"
            class="w-full h-64 object-cover rounded-lg mb-6"
        >

        <p class="mb-4">
            {{ $item->description ?? 'No description available.' }}
        </p>

        <div class="relative"> {{-- Container for relative positioning --}}
            <form action="{{ route('cart.add', $item) }}" method="POST" class="space-y-4">
                @csrf

                <div class="flex items-center space-x-2">
                    <label for="quantity" class="font-medium">Quantity:</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        min="1"
                        value="1"
                        class="w-20 px-2 py-1 border rounded text-center"
                    >
                </div>
                <div>
                    <label for="special_requests" class="font-medium block mb-1">Special Requests:</label>
                    <textarea
                        id="special_requests"
                        name="special_requests"
                        class="w-3/4 border rounded p-2" {{-- Reduced width to 3/4 --}}
                        rows="3"
                        placeholder="Enter any special requests (optional)"
                    ></textarea>
                </div>

                <div class="flex space-x-4">
                    <button
                        type="submit"
                        class="flex-1 bg-yellow-700 text-white py-2 rounded hover:bg-yellow-800"
                    >Add to Cart</button>

                    <a
                        href="{{ route('items.index') }}"
                        class="flex-1 text-center bg-yellow-700 text-white py-2 rounded hover:bg-yellow-800"
                    >Back to Browsing</a>
                </div>
            </form>

            <div class="absolute top-[32px] right-0 flex flex-col space-y-3"> {{-- Attempted top alignment --}}
                @auth
                    <a href="{{ route('items.edit', $item->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="ri-pencil-line" aria-label="Edit Item"></i>
                        <span class="sr-only">Edit</span>
                    </a>
                @endauth
                @auth
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="return confirm('Are you sure you want to delete this item?')">
                            <i class="ri-delete-bin-line" aria-label="Delete Item"></i>
                            <span class="sr-only">Delete</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection