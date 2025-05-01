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
                            <button class="delete-order-btn hidden text-red-500 hover:text-red-700 ml-2" 
                                    data-order-id="{{ $order->id }}">
                                ✕
                            </button>
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
        let deleteMode = false;

        // Toggle delete mode
        deleteBtn.addEventListener('click', function() {
            deleteMode = !deleteMode;
            document.querySelectorAll('.delete-order-btn').forEach(btn => {
                btn.style.display = deleteMode ? 'inline-block' : 'none';
            });
            this.textContent = deleteMode ? 'Cancel Delete' : 'Delete Orders';
            this.classList.toggle('bg-red-500');
            this.classList.toggle('bg-gray-500');
        });

        // Handle delete actions
        document.querySelector('tbody').addEventListener('click', async function(e) {
            const deleteBtn = e.target.closest('.delete-order-btn');
            if (!deleteBtn) return;

            e.preventDefault();
            const orderId = deleteBtn.dataset.orderId;
            const row = deleteBtn.closest('tr');

            if (confirm('Are you sure you want to delete this order?')) {
                try {
                    const response = await fetch(`/orders/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) throw new Error('Failed to delete');
                    
                    row.remove();
                    
                    // Show success message
                    const message = document.createElement('div');
                    message.className = 'bg-green-100 text-green-800 p-3 rounded mb-6';
                    message.textContent = 'Order deleted successfully';
                    document.querySelector('.container').insertBefore(message, document.querySelector('.container').firstChild);
                    setTimeout(() => message.remove(), 3000);
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to delete order');
                }
            }
        });
    });
</script>
@endpush
@endsection
