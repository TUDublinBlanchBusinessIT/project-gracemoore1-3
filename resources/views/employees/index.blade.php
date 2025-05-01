@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Employees</h1>
            <a href="{{ route('employees.create') }}"
               class="bg-yellow-700 hover:bg-yellow-800 text-white font-bold py-2 px-4 rounded">
                Register New Employee
            </a>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->orders()->count() }}</td> {{-- Changed this line --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('employees.edit', $employee) }}" class="text-blue-500 hover:underline">
                                <i class="ri-pencil-line" aria-label="Edit Employee"></i>
                                <span class="sr-only">Edit</span>
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2"
                                        onclick="return confirm('Are you sure you want to delete this employee?')">
                                    <i class="ri-delete-bin-line" aria-label="Delete Employee"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection



