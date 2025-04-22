<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Customer</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-md mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('customers.store') }}" method="POST" class="space-y-4">
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
            <x-button>Save Customer</x-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>


