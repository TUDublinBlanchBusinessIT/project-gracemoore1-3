<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::select('users.id', 'users.name', 'users.email', DB::raw('count(orders.id) as total_orders'))
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create'); // Create a new view for the form
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' adds password_confirmation
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }
    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id, // Ignore the current user's email
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }
}


