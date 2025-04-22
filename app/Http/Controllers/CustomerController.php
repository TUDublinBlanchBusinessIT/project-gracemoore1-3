<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // GET /customers
    public function index()
    {
        // eager‑load the order relation we'll define next
        $customers = Customer::with('mostRecentOrder')->get();
        return view('customers.index', compact('customers'));
    }

    // GET /customers/create
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|string|max:25',
    ]);

    Customer::create($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer added!');
    }

}

