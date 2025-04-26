<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('latestOrder')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
    // eager-load the relation on a single model:
        $customer->load('mostRecentOrder');

        return view('customers.show', compact('customer'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:20',
        // other validation rules
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully');
    }
    // Show “edit” form
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Handle “edit” form submit
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')
                         ->with('success','Customer updated.');
    }

    // Delete the customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
                         ->with('success','Customer deleted.');
    }


}



