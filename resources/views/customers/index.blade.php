@extends('layouts.app')

@section('content')
  {{-- Heading, centered --}}
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold">Customers</h1>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Most Recent Order #</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($customers as $c)
          <tr>
            <td class="px-6 py-4">{{ $c->name }}</td>
            <td class="px-6 py-4">{{ $c->number }}</td>
            <td class="px-6 py-4">{{ optional($c->mostRecentOrder)->id ?? '—' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No customers yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Add button, centered --}}
  <div class="mt-6 flex justify-center">
    <a href="{{ route('customers.create') }}"
       class="px-6 py-3 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800">
      Add New Customer
    </a>
  </div>
@endsection
