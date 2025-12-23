<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
 public function index(Request $request)
{
    $query = Item::query();

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    return response()->json($query->latest()->get());
}


    public function show($id)
    {
        return Item::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'category' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('items', 'public');
        }

        return Item::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price,
            'discount' => $request->discount,
            'category' => $request->category,
            'img' => $path,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if ($request->hasFile('img')) {
            $item->img = $request->file('img')->store('items', 'public');
        }

        $item->update($request->except('img'));

        return response()->json(['message' => 'Updated']);
    }

    public function destroy($id)
    {
        Item::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
