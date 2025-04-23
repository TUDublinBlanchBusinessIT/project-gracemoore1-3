<?php

namespace App\Http\Controllers;

use App\Models\BakeryItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, BakeryItem $item)
    {
        $qty = max(1, (int) $request->input('quantity', 1));

        // pull existing cart from session (item_id => [qty,name,price,image])
        $cart = session()->get('cart', []);

        // increment or set
        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] += $qty;
        } else {
            $cart[$item->id] = [
                'name'     => $item->name,
                'price'    => $item->price,
                'image'    => $item->image,
                'quantity' => $qty,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', "{$item->name} ({$qty}) added to cart.");
    }
}
