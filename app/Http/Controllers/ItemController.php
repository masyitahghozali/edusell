<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // SHOW SELL FORM (sellitempage.blade.php)
    public function create()
    {
        return view('auth.sellitempage');
    }

    // STORE NEW ITEM
    public function store(Request $request)
    {
        $request->validate([
            'item_name'        => 'required|string|max:255',
            'item_price'       => 'required|numeric|min:0',
            'item_condition'   => 'required|string|max:255',
            'item_category'    => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'item_status'      => 'required|in:available,reserved,sold',
            'item_image'       => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('item_image')) {
            // items/<random>.jpg stored in storage/app/public
            $path = $request->file('item_image')->store('items', 'public');
        }

        Item::create([
            'user_id'          => Auth::id(),
            'item_name'        => $request->item_name,
            'item_price'       => $request->item_price,
            'item_condition'   => $request->item_condition,
            'item_category'    => $request->item_category,
            'item_description' => $request->item_description,
            'item_status'      => $request->item_status,
            'item_image'       => $path,
        ]);

        return redirect()
            ->route('listingpage')
            ->with('success', 'Item created successfully.');
    }

    // LIST LOGGED-IN USER'S ITEMS (listingpage.blade.php)
    public function index()
    {
        $items = Item::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('auth.listingpage', compact('items'));
    }

    // SHOW ONE ITEM (itemdetailpage.blade.php)
    public function show(Item $item)
    {
        $item->load('user');

        return view('auth.itemdetailpage', compact('item'));
    }

    // SHOW EDIT FORM (editmyitempage.blade.php)
    public function edit(Item $item)
    {
        // Make sure the item belongs to current user
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        return view('auth.editmyitempage', compact('item'));
    }

    // UPDATE ITEM
    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'item_name'        => 'required|string|max:255',
            'item_price'       => 'required|numeric|min:0',
            'item_condition'   => 'required|string|max:255',
            'item_category'    => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'item_status'      => 'required|in:available,reserved,sold',
            'item_image'       => 'nullable|image|max:2048',
        ]);

        // New image?
        if ($request->hasFile('item_image')) {
            if ($item->item_image) {
                Storage::disk('public')->delete($item->item_image);
            }
            $item->item_image = $request->file('item_image')->store('items', 'public');
        }

        $item->item_name        = $request->item_name;
        $item->item_price       = $request->item_price;
        $item->item_condition   = $request->item_condition;
        $item->item_category    = $request->item_category;
        $item->item_description = $request->item_description;
        $item->item_status      = $request->item_status;

        $item->save();

        return redirect()
            ->route('listingpage')
            ->with('success', 'Item updated successfully.');
    }

    // DELETE ITEM
    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        if ($item->item_image) {
            Storage::disk('public')->delete($item->item_image);
        }

        $item->delete();

        return redirect()
            ->route('listingpage')
            ->with('success', 'Item deleted successfully.');
    }

    // 🔹 TOGGLE LIKE / UNLIKE
    public function toggleLike(Item $item)
    {
        $user = Auth::user();

        // Uses belongsToMany "likedItems" relation on User
        $user->likedItems()->toggle($item->item_id);

        return back();
    }

    // 🔹 SHOW LIKED ITEMS PAGE
    public function likedItems()
    {
        $user = Auth::user();

        // Load liked items (optionally hide sold ones)
        $items = $user->likedItems()
            ->where('item_status', '!=', 'sold')
            ->with('user')
            ->latest('item_likes.created_at')
            ->get();

        return view('auth.likeitempage', compact('items'));
    }
}
