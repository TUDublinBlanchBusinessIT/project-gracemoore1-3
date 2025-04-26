<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $customers = Customer::all();
        $pickupDateTime = now()->addDay()->format('Y-m-d\TH:i');
        return view('orders.create', compact('customers','pickupDateTime'));
    }

    public function index()
    {
        $orders = Order::with(['customer', 'user'])
                    ->orderBy('created_at','desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'name' => 'nullable|required_without:customer_id|string|max:255',
            'number' => 'nullable|required_without:customer_id|string|max:50',
            'pickup_datetime' => 'required|date',
        ]);

        if (!$data['customer_id']) {
            $c = Customer::create([
                'name' => $data['name'],
                'number' => $data['number'],
            ]);
            $data['customer_id'] = $c->id;
        }

        $data['user_id'] = auth()->id();

        $cart = Session::get('cart', []);
        $total = 0;
        $pieces = [];

        foreach ($cart as $line) {
            $qty = $line['quantity'];
            $price = $line['price'];
            $name = $line['name'];

            $total += $qty * $price;
            $pieces[] = $qty . ' ' . $name . ($qty>1 ? 's' : '');
        }

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'pickup_datetime' => $data['pickup_datetime'],
            'total_price' => $total,
            'list_of_items' => implode(' and ', $pieces),
            'user_id' => $data['user_id'],
        ]);

        Customer::find($order->customer_id)
            ->update(['most_recent_order_id' => $order->id]);

        Session::forget('cart');

        return redirect()
            ->route('items.index')
            ->with('success', "Order #{$order->id} placed!");
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pickup_datetime' => 'required|date',
            'total_price' => 'required|numeric|min:0',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
                        ->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();

    // Optionally, you can return a response for the AJAX request
        return response()->json(['success' => 'Order deleted successfully']);
    }

}