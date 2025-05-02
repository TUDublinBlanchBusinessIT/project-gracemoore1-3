@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Our Bakery</h1>
        <div class="flex space-x-2">
            <a href="{{ route('items.create') }}"
                class="bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-800">
                Add New Item
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-6 text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- PROMO SECTION --}}
    @php
        $promoItems = $items->whereIn('name', ['Chocolate Cake', 'Chocolate Cupcake Box', 'Vanilla Iced Cake', 'Brookie Tray','Cookie Box']);
    @endphp
    
    @if($promoItems->count())
    <div class="bg-amber-50 border-2 border-dashed border-amber-200 rounded-xl p-6 mb-8 text-center">
        <h2 class="text-2xl font-bold text-amber-800 mb-6">ONE NOT ENOUGH?</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($promoItems as $item)
                <div class="w-full sm:w-[calc(33.333%-1rem)] border rounded-lg overflow-hidden shadow hover:shadow-lg transition bg-white">
                    <a href="{{ route('items.show', $item) }}">
                        <img src="{{ asset('images/'.$item->image) }}" 
                             alt="{{ $item->name }}"
                             class="w-full h-32 object-cover">
                    </a>
                    <div class="p-3">
                        <h3 class="font-semibold">{{ $item->name }}</h3>
                        <p class="text-amber-600">${{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-amber-600 italic mt-4">Mix & Match – Order a Variety Today!</p>
    </div>
    @endif

    {{-- MAIN ITEMS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($items->whereNotIn('name', ['Chocolate Cake', 'Chocolate Cupcake Box', 'Vanilla Iced Cake', 'Brookie Tray','Cookie Box']) as $item)
            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                <a href="{{ route('items.show', $item) }}">
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

