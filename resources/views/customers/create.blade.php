<x-app-layout>
  <div class="max-w-md mx-auto sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-4">Add Customer</h1>

    <form action="{{ route('customers.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
      @csrf

      <div>
        <x-label for="name" value="Name" />
        <x-input id="name" name="name" class="mt-1 block w-full" required />
      </div>

      <div>
        <x-label for="number" value="Phone Number" />
        <x-input id="number" name="number" class="mt-1 block w-full" required />
      </div>

      <div>
        <x-label for="most_recent_order_id" value="Most Recent Order (ID)" />
        <x-input id="most_recent_order_id" name="most_recent_order_id" 
                 type="number" class="mt-1 block w-full" />
      </div>

      <div class="flex justify-end">
        <x-button>
          Save Customer
        </x-button>
      </div>
    </form>
  </div>
</x-app-layout>
