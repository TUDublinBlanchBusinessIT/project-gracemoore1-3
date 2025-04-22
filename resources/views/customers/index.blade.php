<x-app-layout>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Customers</h1>
      <a href="{{ route('customers.create') }}"
         class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
        Add Customer
      </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Most Recent Order</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($customers as $cust)
            <tr>
              <td class="px-6 py-4">{{ $cust->name }}</td>
              <td class="px-6 py-4">{{ $cust->number }}</td>
              <td class="px-6 py-4">
                {{ $cust->mostRecentOrder ? $cust->mostRecentOrder->id : '—' }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>
