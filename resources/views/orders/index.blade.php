@extends('layouts.app')

@section('content')
    <div class="flex justify-end items-center mb-6">
        <button id="delete-orders-btn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Delete Orders
        </button>
    </div>

    <h1 class="text-3xl font-bold mb-4">Orders</h1>

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
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase delete-column" style="display: none;">Delete</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr data-order-id="{{ $order->id }}">
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
                        <td class="px-6 py-4 delete-column" style="display: none;">
                            <button class="delete-order-icon text-red-600 hover:text-red-800 focus:outline-none"
                                    data-order-id="{{ $order->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 inline-block">
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

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteOrdersBtn = document.getElementById('delete-orders-btn');
                const deleteColumns = document.querySelectorAll('.delete-column');
                const deleteIcons = document.querySelectorAll('.delete-order-icon');
                const deleteForm = document.getElementById('delete-form');
                const ordersTableBody = document.querySelector('tbody');

                deleteOrdersBtn.addEventListener('click', function() {
                    deleteColumns.forEach(column => {
                        column.style.display = column.style.display === 'none' ? 'table-cell' : 'none';
                    });

                    // Optionally, change the button text
                    deleteOrdersBtn.textContent = deleteColumns[0].style.display === 'none' ? 'Delete Orders' : 'Cancel Delete';
                });

                deleteIcons.forEach(icon => {
                    icon.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent potential form submissions
                        const orderId = this.dataset.orderId;
                        const rowToRemove = this.closest('tr');

                        if (confirm('Are you sure you want to delete order #' + orderId + '?')) {
                            deleteForm.action = '/orders/' + orderId;

                            fetch(deleteForm.action, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                    'X-CSRF-TOKEN': deleteForm.querySelector('input[name="_token"]').value,
                                    '_method': 'DELETE'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    rowToRemove.remove();
                                    // Optionally, display a success message
                                } else {
                                    console.error('Error deleting order:', response);
                                    // Optionally, display an error message
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                // Optionally, display an error message
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
