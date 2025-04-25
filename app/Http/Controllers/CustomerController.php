<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['orders' => function($q){
            $q->latest('created_at')->limit(1);
        }])->get();

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
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        Customer::create($data);

        $order->customer->update([
            'most_recent_order_id' => $order->id
        ]);        

        return redirect()->route('customers.index')
                         ->with('success','Customer added.');
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



