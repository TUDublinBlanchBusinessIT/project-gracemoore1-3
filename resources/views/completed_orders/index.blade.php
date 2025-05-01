@extends('layouts.app')
    
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Completed Orders</h1>
    
    @if($completedOrders->isEmpty())
        <p class="text-gray-600">No completed orders.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items Ordered</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($completedOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->items_ordered }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection