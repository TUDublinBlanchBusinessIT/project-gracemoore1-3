<?php

namespace App\Http\Controllers;

use App\Models\BakeryItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(function($line){
            return $line['price'] * $line['quantity'];
        });
        return view('cart.index', compact('cart','total'));
    }

    public function store(Request $request, BakeryItem $item)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);
        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] += $qty;
        } else {
            $cart[$item->id] = [
                'name'     => $item->name,
                'price'    => $item->price,
                'image'    => $item->image,
                'quantity' => $qty,
                'special_requests' => $request->input('special_requests'),
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success', "{$item->name} ({$qty}) added to cart.");
    }

    public function update(Request $request, BakeryItem $item)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] = $qty;
            session(['cart' => $cart]);
        }
        return back()->with('success','Quantity updated.');
    }

    public function destroy(BakeryItem $item)
    {
        $cart = session('cart', []);
        unset($cart[$item->id]);
        session(['cart' => $cart]);
        return back()->with('success','Item removed.');
    }
}
