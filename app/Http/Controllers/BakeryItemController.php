<?php

namespace App\Http\Controllers;

use App\Models\BakeryItem;
use Illuminate\Http\Request;

class BakeryItemController extends Controller
{
    public function index()
    {
        $items = BakeryItem::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'required|image',
        ]);

            // 1) grab the uploaded file
        $file = $request->file('image');

    // 2) pull its original client‐side name
        $originalName = $file->getClientOriginalName();

    // 3) move it into public/images under that very name
        $file->move(public_path('images'), $originalName);

       

        BakeryItem::create([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
            'image'       => $originalName,
        ]);

        return redirect()->route('items.index')
                         ->with('success', 'Item added.');
    }

    public function show(BakeryItem $item)
    {
        return view('items.show', compact('item'));
    }

    // (you can add edit/update/destroy later)
}


