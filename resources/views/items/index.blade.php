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

    {{-- COMPACT PROMO SECTION - 6 ITEMS PER ROW --}}
    @php
        $promoItems = $items->whereIn('name', ['Chocolate Cake', 'Cupcake Box', 'Vanilla Iced Cake', 'Brookie Tray','Cookie Box','Cinnamon Roll Box']);
    @endphp
    
    @if($promoItems->count())
    <div class="mb-6 text-center">
        <h2 class="text-lg font-bold text-amber-800 mb-2">ONE NOT ENOUGH?</h2>
        <div class="flex flex-wrap justify-center gap-1 max-w-3xl mx-auto border border-amber-200 rounded-lg p-2 bg-amber-50">
            @foreach($promoItems as $item)
                <div class="w-[15.5%] min-w-[75px] border border-amber-100 rounded-md overflow-hidden shadow-sm hover:shadow-md bg-white">
                    <a href="{{ route('items.show', $item) }}">
                        <img src="{{ asset('images/'.$item->image) }}" 
                             alt="{{ $item->name }}"
                             class="w-full h-20 object-cover">
                    </a>
                    <div class="p-1">
                        <h3 class="font-medium text-xs truncate">{{ $item->name }}</h3>
                        <p class="text-amber-600 text-xs">${{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-amber-600 italic mt-2 text-xs">Mix & Match – Order a Variety Today!</p>
    </div>
    @endif

    {{-- MAIN ITEMS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($items->whereNotIn('name', ['Chocolate Cake', 'Cupcake Box', 'Vanilla Iced Cake', 'Brookie Tray','Cookie Box','Cinnamon Roll Box']) as $item)
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

