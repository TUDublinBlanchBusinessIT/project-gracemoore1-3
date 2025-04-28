<?php

namespace App\Http\Controllers;

use App\Models\BakeryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('public/images');
        $originalName = $request->file('image')->getClientOriginalName(); // Get original name
        $data['image'] = $originalName; // Store original name in DB
        $data['image_path'] = str_replace('public/', '', $imagePath);

        BakeryItem::create($data);

        return redirect()->route('items.index')
            ->with('success', 'Item added.');
    }

    public function show(BakeryItem $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(BakeryItem $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, BakeryItem $item)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::delete('public/' . $item->image_path);
            $imagePath = $request->file('image')->store('public/images');
             $originalName = $request->file('image')->getClientOriginalName();
            $data['image'] = $originalName;
            $data['image_path'] = str_replace('public/', '', $imagePath);
        }



        $item->update($data);

        return redirect()->route('items.index')
            ->with('success', 'Item updated.');
    }

    public function destroy(BakeryItem $item)
    {
        // Delete the image file
        Storage::delete('public/' . $item->image_path);
        $item->delete();
        return redirect()->route('items.index')
            ->with('success', 'Item deleted.');
    }
}



