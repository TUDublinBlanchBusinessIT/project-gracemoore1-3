@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Order Details #{{ $order->id }}</h1>
        
        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <h2 class="font-semibold">Customer:</h2>
                    <p>{{ $order->customer->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <h2 class="font-semibold">Order Total:</h2>
                    <p>${{ number_format($order->total_price, 2) }}</p>
                </div>
                <div>
                    <h2 class="font-semibold">Pickup Time:</h2>
                    <p>{{ \Carbon\Carbon::parse($order->pickup_datetime)->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold">Items:</h2>
                <p>{{ $order->list_of_items }}</p>
            </div>

            <a href="{{ route('orders.index') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Back to Orders
            </a>
        </div>
    </div>
@endsection