<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show the “enter customer info” form.
     */
    public function create()
    {
        // grab every existing customer
        $customers = Customer::all();

        return view('orders.create', compact('customers'));
    }

    /**
     * Handle the form POST and actually save the order.
     */
    public function store(Request $request)
    {
        // 1) validate: either they picked an existing customer_id,
        // or they must supply name+number for a new one
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'name'        => 'nullable|string|required_without:customer_id|max:255',
            'number'      => 'nullable|string|required_without:customer_id|max:50',
            'pickup_datetime' => 'required|date', 
        ]);

        // 2) if no existing customer was chosen, create it now
        if (! $data['customer_id']) {
            $new = Customer::create([
                'name'   => $data['name'],
                'number' => $data['number'],
            ]);
            $data['customer_id'] = $new->id;
        }

        // 3) now create the order record (customize as needed)
        Order::create([
            'customer_id' => $data['customer_id'],
            'pickup_datetime' => $data['pickup_datetime'],
            // … add any other order fields here …
        ]);

        // 4) redirect back to browsing with a success flash
        return redirect()
            ->route('items.index')
            ->with('success', 'Order placed!');
    }

    // (other resource methods can stay empty or be removed if you aren't using them)
}

