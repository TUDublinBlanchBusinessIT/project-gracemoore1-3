@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col mb-6">
        <h1 class="text-3xl font-bold mb-4">Orders</h1>

        <div class="flex justify-end">
            <button id="delete-orders-btn"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors mb-4">
                Delete Orders
            </button>
        </div>
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
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Pick-up</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Status</th> </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr data-order-id="{{ $order->id }}" class="hover:bg-gray-50">
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
                               class="text-yellow-600 hover:underline">
                                <i class="ri-eye-line" aria-label="View Order"></i>
                                <span class="sr-only">View Order</span>
                            </a>
                            <a href="{{ route('orders.edit', $order) }}"
                               class="text-blue-600 hover:underline">
                                <i class="ri-pencil-line" aria-label="Edit Order"></i>
                                <span class="sr-only">Edit Order</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('orders.complete', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Completed
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('delete-orders-btn');
        const deleteColumns = document.querySelectorAll('.delete-column');


        // Toggle delete mode
        deleteBtn.addEventListener('click', function() {
            const isDeleteMode = deleteColumns[0].classList.contains('hidden');

            // Toggle visibility
            deleteColumns.forEach(col => {
                col.classList.toggle('hidden');
            });


            deleteBtn.textContent = isDeleteMode ? 'Cancel Delete' : 'Delete Orders';
            deleteBtn.classList.toggle('bg-red-500');
            deleteBtn.classList.toggle('bg-gray-500');
        });

        // Handle delete actions
        document.querySelector('tbody').addEventListener('click', async function(e) {
            const deleteOrderButton = e.target.closest('.delete-order-btn');
            if (!deleteOrderButton) return;

            e.preventDefault();
            e.stopPropagation();

            const orderId = deleteOrderButton.dataset.orderId;
            const row = deleteOrderButton.closest('tr');

            if (confirm('Are you sure you want to delete this order?')) {
                try {
                    const response = await fetch(`/orders/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'include'
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to delete order');
                    }

                    row.remove();


                    const message = document.createElement('div');
                    message.className = 'bg-green-100 text-green-800 p-3 rounded mb-6';
                    message.textContent = 'Order deleted successfully';
                    document.querySelector('.container').insertBefore(message, document.querySelector('.container').firstChild);

                    setTimeout(() => message.remove(), 3000);

                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message || 'Error deleting order');
                }
            }
        });
    });
</script>
@endpush
@endsection
