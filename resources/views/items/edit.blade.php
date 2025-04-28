@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Bakery Item</h1>

    <form action="{{ route('items.update', $item->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4 max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1" for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ $item->name }}"
                   class="w-full border rounded p-2" required>
            @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="price">Price</label>
            <input id="price" name="price" type="number" step="0.01"
                   value="{{ $item->price }}" class="w-full border rounded p-2" required>
            @error('price') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="description">Description</label>
            <textarea id="description" name="description"
                      class="w-full border rounded p-2" rows="3">{{ $item->description }}</textarea>
            @error('description') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1" for="image">Image</label>
            <input id="image" name="image" type="file" class="w-full">
            <img src="{{ asset('images/'.$item->image) }}" alt="{{$item->name}}" style="max-width: 200px; height: auto;">
            @error('image') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="text-center">
            <button type="submit"
                    class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">
                Update Item
            </button>
            <a href="{{ route('items.index') }}"
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 ml-2">
                Cancel
            </a>
        </div>
    </form>
@endsection
