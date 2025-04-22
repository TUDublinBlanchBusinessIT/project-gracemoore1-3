@extends('layouts.app')

@section('content')
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold">Customers</h1>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Most Recent Order #</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($customers as $c)
          <tr>
            <td class="px-6 py-4">{{ $c->name }}</td>
            <td class="px-6 py-4">{{ $c->number }}</td>
            <td class="px-6 py-4">{{ optional($c->mostRecentOrder)->id ?? '—' }}</td>
            <td class="px-6 py-4 text-center space-x-2">
              <!-- Edit -->
              <a href="{{ route('customers.edit', $c) }}"
                 class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Edit
              </a>
              <!-- Delete -->
              <form action="{{ route('customers.destroy', $c) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Delete this customer?')"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No customers yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6 flex justify-center">
    <a href="{{ route('customers.create') }}"
       class="px-6 py-3 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800">
      Add New Customer
    </a>
  </div>
@endsection

