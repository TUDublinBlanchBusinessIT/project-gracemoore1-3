@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Order #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Orders
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_id" class="block font-medium text-gray-700 mb-1">Customer</label>
                        <select name="customer_id" id="customer_id" class="w-full rounded border-gray-300">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="pickup_datetime" class="block font-medium text-gray-700 mb-1">Pickup Date/Time</label>
                        <input type="datetime-local" name="pickup_datetime" id="pickup_datetime" 
                               value="{{ \Carbon\Carbon::parse($order->pickup_datetime)->format('Y-m-d\TH:i') }}"
                               class="w-full rounded border-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Items</label>
                    <div class="bg-gray-50 p-4 rounded">
                        {{ $order->list_of_items }}
                    </div>
                </div>

                <div>
                    <label for="total_price" class="block font-medium text-gray-700 mb-1">Total Price</label>
                    <input type="number" step="0.01" name="total_price" id="total_price" 
                           value="{{ $order->total_price }}"
                           class="w-full rounded border-gray-300">
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4">
                <button type="submit" 
                        class="bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-800">
                    Update Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection