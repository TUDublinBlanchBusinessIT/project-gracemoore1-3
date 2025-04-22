<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // show the table of customers
    public function index()
    {
        // eager‑load the “mostRecentOrder” relation
        $customers = Customer::with('mostRecentOrder')->get();
        return view('customers.index', compact('customers'));
    }

    // show the “add customer” form
    public function create()
    {
        return view('customers.create');
    }

    // handle the form POST and save a new customer
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')
                         ->with('success','Customer added.');
    }
}


