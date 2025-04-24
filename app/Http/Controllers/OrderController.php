<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Show the form to create a new order
    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    // Handle the POST from that form and actually save the order
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'     => 'nullable|exists:customers,id',
            'name'            => 'required_without:customer_id|string|max:255',
            'number'          => 'required_without:customer_id|string|max:50',
            'pickup_datetime' => 'required|date',
        ]);

        // If they didn’t pick an existing customer, make a new one
        if (! $data['customer_id']) {
            $new = Customer::create([
                'name'   => $data['name'],
                'number' => $data['number'],
            ]);
            $data['customer_id'] = $new->id;
        }

        // Pull cart from session, build item list + total
        $cart  = session()->get('cart', []);
        $lines = [];
        $total = 0;
        foreach ($cart as $item) {
            $lines[] = "{$item['quantity']} {$item['name']}";
            $total += $item['price'] * $item['quantity'];
        }

        // Create the order
        Order::create([
            'customer_id'     => $data['customer_id'],
            'user_id'         => Auth::id(),              // employee is the logged‐in user
            'pickup_datetime' => $data['pickup_datetime'],
            'total_price'     => $total,
            'list_of_items'   => implode(' and ', $lines),
        ]);

        // Empty the cart
        session()->forget('cart');

        return redirect()
            ->route('items.index')
            ->with('success','Order placed!');
    }
}
