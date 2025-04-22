@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Customers</h1>
    <a href="{{ route('customers.create') }}"
       class="px-4 py-2 bg-yellow-700 text-white rounded hover:bg-yellow-800">
      Add Customer
    </a>
  </div>

  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Most Recent Order #</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($customers as $c)
          <tr>
            <td class="px-6 py-4">{{ $c->name }}</td>
            <td class="px-6 py-4">{{ $c->number }}</td>
            <td class="px-6 py-4">
              {{ optional($c->mostRecentOrder)->id ?? '—' }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No customers yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

