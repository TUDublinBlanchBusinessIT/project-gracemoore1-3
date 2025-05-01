<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\CompletedOrder; // Add this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; // Add this

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
        return view('orders.create', compact('customers', 'pickupDateTime'));
    }

    public function index()
    {
        $orders = Order::with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
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
        $allSpecialRequests = [];

        foreach ($cart as $itemId => $line) {
            $qty = $line['quantity'];
            $price = $line['price'];
            $name = $line['name'];
            $specialRequests = $line['special_requests'] ?? null;

            $total += $qty * $price;
            $pieces[] = $qty . ' ' . $name . ($qty > 1 ? 's' : '');
            if ($specialRequests) {
                $allSpecialRequests[] = $specialRequests;
            }
        }

        \Log::info('Special Requests Array:', ['special_requests' => $allSpecialRequests]);

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'pickup_datetime' => $data['pickup_datetime'],
            'total_price' => $total,
            'list_of_items' => implode(' and ', $pieces),
            'user_id' => $data['user_id'],
            'special_requests' => implode('; ', $allSpecialRequests),
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
        \Log::info("Delete attempt for order: " . $order->id);
        try {
            $order->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true])
                : redirect()->route('orders.index')->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            return request()->wantsJson()
                ? response()->json(['error' => $e->getMessage()], 500)
                : redirect()->route('orders.index')->with('error', 'Failed to delete order');
        }
    }

    public function completeOrder(Request $request, $id)  // Added this method
    {
        //use a transaction for atomicity
        DB::transaction(function () use ($id) {
            $order = Order::findOrFail($id);

            CompletedOrder::create([
                'order_id' => $order->id,
                'total_price' => $order->total_price,
                'items_ordered' => $order->list_of_items, // Corrected this
                'customer_id' => $order->customer_id,
            ]);

            $order->delete();
        });


        return redirect()->route('orders.index')->with('success', 'Order completed and moved.');
    }
}