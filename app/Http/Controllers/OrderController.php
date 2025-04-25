<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /** Show the “Customer Information” form */
    public function create()
    {
        // load all existing customers into a dropdown
        $customers = Customer::all();

        // default pickup to tomorrow at 17:00
        $pickupDateTime = now()->addDay()->format('Y-m-d\TH:i');

        return view('orders.create', compact('customers','pickupDateTime'));
    }

    public function index()
    {
        $orders = Order::with(['customer','user'])
                    ->orderBy('created_at','desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }
    /** Handle the form POST, save the order, clear the cart */
    public function store(Request $request)
    {
        // 1. Validation
        $data = $request->validate([
            'customer_id'     => 'nullable|exists:customers,id',
            'name'            => 'nullable|required_without:customer_id|string|max:255',
            'number'          => 'nullable|required_without:customer_id|string|max:50',
            'pickup_datetime' => 'required|date',
        ]);        
 

        // 2. If they didn’t pick an existing customer, create one
        if ( ! $data['customer_id'] ) {
            $c = Customer::create([
                'name'   => $data['name'],
                'number' => $data['number'],
            ]);
            $data['customer_id'] = $c->id;
        }

        $data['user_id'] = auth()->id();  // instead of employee_id


        // 3. Build the order’s total & list_of_items from the session cart
        $cart = Session::get('cart', []);
        $total = 0;
        $pieces = [];

        foreach ($cart as $line) {
            $qty   = $line['quantity'];
            $price = $line['price'];
            $name  = $line['name'];

            $total += $qty * $price;
            $pieces[] = $qty . ' ' . $name . ($qty>1 ? 's' : '');
        }

        // 4. Persist the order
        $order = Order::create([
            'customer_id'     => $data['customer_id'],
            'pickup_datetime' => $data['pickup_datetime'],
            'total_price'     => $total,
            'list_of_items'   => implode(' and ', $pieces),
            'user_id'         => Auth()->id(),      // who took it
        ]);

        $customer = Customer::find($order->customer_id)
                ->update(['most_recent_order_id' => $order->id]);


        // 5. Empty the cart
        Session::forget('cart');

        // 6. Redirect back to the bakery with a flash
        return redirect()
            ->route('items.index')
            ->with('success',"Order #{$order->id} placed!");
    }
}

