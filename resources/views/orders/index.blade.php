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
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase delete-column hidden">Delete</th>
                    </tr>
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
                               class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('orders.edit', $order) }}"
                               class="text-yellow-600 hover:underline">Edit</a>
                        </td>
                        <td class="px-6 py-4 delete-column hidden">
                            <button class="delete-order-btn text-red-600 hover:text-red-800 focus:outline-none"
                                    data-order-id="{{ $order->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
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
        const deleteButtons = document.querySelectorAll('.delete-order-btn');
        
        // Toggle delete mode
        deleteBtn.addEventListener('click', function() {
            const isDeleteMode = deleteColumns[0].classList.contains('hidden');
            
            // Toggle visibility
            deleteColumns.forEach(col => {
                col.classList.toggle('hidden');
            });
            
            // Update button text
            deleteBtn.textContent = isDeleteMode ? 'Cancel Delete' : 'Delete Orders';
            deleteBtn.classList.toggle('bg-red-500');
            deleteBtn.classList.toggle('bg-gray-500');
        });
        
        // Handle delete actions
        document.querySelector('tbody').addEventListener('click', function(e) {
            if (e.target.closest('.delete-order-btn')) {
                const button = e.target.closest('.delete-order-btn');
                const orderId = button.dataset.orderId;
                const row = button.closest('tr');
                
                if (confirm('Are you sure you want to delete this order?')) {
                    fetch(`/orders/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            row.remove();
                            // Show success message
                            const message = document.createElement('div');
                            message.className = 'bg-green-100 text-green-800 p-3 rounded mb-6 mt-4';
                            message.textContent = 'Order deleted successfully';
                            document.querySelector('.container').prepend(message);
                            setTimeout(() => message.remove(), 3000);
                        } else {
                            alert('Failed to delete order');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting order');
                    });
                }
            }
        });
    });
</script>
@endpush
@endsection
