@extends('layouts.app')

@section('content')
  <h1 class="text-3xl font-bold mb-6 text-center">Add New Bakery Item</h1>

  <form action="{{ route('items.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4 max-w-lg mx-auto">
    @csrf

    <div>
      <label class="block font-medium mb-1" for="name">Name</label>
      <input id="name" name="name" type="text" value="{{ old('name') }}"
             class="w-full border rounded p-2" required>
      @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-medium mb-1" for="price">Price</label>
      <input id="price" name="price" type="number" step="0.01"
             value="{{ old('price') }}" class="w-full border rounded p-2" required>
      @error('price') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-medium mb-1" for="description">Description</label>
      <textarea id="description" name="description"
                class="w-full border rounded p-2" rows="3">{{ old('description') }}</textarea>
      @error('description') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block font-medium mb-1" for="image">Image</label>
      <input id="image" name="image" type="file" class="w-full" required>
      @error('image') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="text-center">
      <button type="submit"
              class="bg-yellow-700 text-white px-6 py-2 rounded hover:bg-yellow-800">
        Save Item
      </button>
    </div>
  </form>
@endsection

