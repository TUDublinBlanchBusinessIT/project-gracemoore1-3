@extends('layouts.app')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Orders</h1>
    <a href="{{ route('orders.create') }}"
       class="bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-800">
      New Order
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  @if($orders->isEmpty())
    <p class="text-gray-600">No orders placed yet.</p>
  @else
    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr class="text-left">
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">User</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Pick-up</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Items</th>
            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($orders as $order)
            <tr>
              <td class="px-6 py-4">{{ $order->id }}</td>
              <td class="px-6 py-4">{{ $order->customer->name ?? 'N/A' }}</td>
              <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
              <td class="px-6 py-4">
                {{ \Carbon\Carbon::parse($order->pickup_datetime)->format('d/m/Y H:i') }}
              </td>
              <td class="px-6 py-4">${{ number_format($order->total_price, 2) }}</td>
              <td class="px-6 py-4">{{ Str::limit($order->list_of_items, 30) }}</td>
              <td class="px-6 py-4 space-x-2">
                <a href="{{ route('orders.show', $order) }}"
                   class="text-blue-600 hover:underline">View</a>
                <a href="{{ route('orders.edit', $order) }}"
                   class="text-yellow-600 hover:underline">Edit</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
