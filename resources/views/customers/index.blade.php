@extends('layouts.app')

@section('content')
  <div class="w-full max-w-3xl bg-yellow-50 p-8 rounded-2xl shadow-lg mt-12">
    
    {{-- Heading --}}
    <h1 class="text-3xl font-bold text-center mb-6">Customers</h1>

    {{-- Success flash --}}
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto mb-6">
      <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase">Name</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase">Phone</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase">Most Recent Order #</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customers as $c)
            <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
              <td class="px-4 py-3">{{ $c->name }}</td>
              <td class="px-4 py-3">{{ $c->number }}</td>
              <td class="px-4 py-3">{{ optional($c->mostRecentOrder)->id ?? '—' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="px-4 py-3 text-center text-gray-500">No customers yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Add button --}}
    <div class="flex justify-center">
      <a href="{{ route('customers.create') }}"
         class="bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2 px-6 rounded">
        Add New Customer
      </a>
    </div>
  </div>
@endsection



