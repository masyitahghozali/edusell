<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Item;

/*
|--------------------------------------------------------------------------
| Public (no login)
|--------------------------------------------------------------------------
*/

Route::view('/', 'auth.landingpage');
Route::view('/login', 'auth.loginpage')->name('loginpage');

/*
|--------------------------------------------------------------------------
| Protected routes (must be logged in)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // === MAIN HOMEPAGE AFTER LOGIN ===
    Route::get('/homepage', function (Request $request) {
        $search   = $request->get('q');         // text in search bar
        $category = $request->get('category');  // all / Books / Stationaries / Electronics / Others

        // Base query:
        //  - load seller (user)
        //  - HIDE items that are sold
        //  - HIDE items that belong to the logged-in user
        $query = Item::with('user')
            ->where('item_status', '!=', 'sold')
            ->where('user_id', '!=', auth()->id())
            ->latest();

        // Search by item title
        if (!empty($search)) {
            $query->where('item_name', 'like', '%' . $search . '%');
        }

        // Filter by category (ignore if "all" or empty)
        if (!empty($category) && $category !== 'all') {
            $query->where('item_category', $category);
        }

        $items = $query->get();

        // If you have likedItems() relation; otherwise this will just be []
        $user = auth()->user();
        if (method_exists($user, 'likedItems')) {
            $likedItemIds = $user->likedItems()
                ->pluck('items.item_id')
                ->toArray();
        } else {
            $likedItemIds = [];
        }

        return view('auth.homepage', [
            'items'        => $items,
            'search'       => $search,
            'category'     => $category ?? 'all',
            'likedItemIds' => $likedItemIds,
        ]);
    })->name('homepage');

    // Breeze redirects to dashboard → send to homepage
    Route::get('/dashboard', function () {
        return redirect()->route('homepage');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ITEMS (sell page, listings, CRUD, likes)
    |--------------------------------------------------------------------------
    */

    // Sell item form
    Route::get('/sell-item', [ItemController::class, 'create'])
        ->name('sellitempage');

    // Store new item
    Route::post('/items', [ItemController::class, 'store'])
        ->name('items.store');

    // My listings (only logged-in user's items)
    Route::get('/my-listings', [ItemController::class, 'index'])
        ->name('listingpage');

    // Edit item page
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])
        ->name('items.edit');

    // Update item
    Route::put('/items/{item}', [ItemController::class, 'update'])
        ->name('items.update');

    // Delete item
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])
        ->name('items.destroy');

    // Item detail (dynamic)
    Route::get('/items/{item}', [ItemController::class, 'show'])
        ->name('itemdetailpage');

    // Toggle like / unlike
    Route::post('/items/{item}/toggle-like', [ItemController::class, 'toggleLike'])
        ->name('items.toggle-like');

    // Liked items page
    Route::get('/likes', [ItemController::class, 'likedItems'])
        ->name('likeitempage');

    /*
    |--------------------------------------------------------------------------
    | INBOX + CHAT (ChatController)
    |--------------------------------------------------------------------------
    */

    // Inbox page – list of conversations
    Route::get('/inbox', [ChatController::class, 'inbox'])
        ->name('inboxpage');

    // Chat with another user.
    // Path param: {user}
    // Item is passed as query ?item=ID
    Route::get('/chat/{user}', [ChatController::class, 'show'])
        ->name('chatpage');

    // Send a message in that chat (same URL, POST)
    Route::post('/chat/{user}', [ChatController::class, 'send'])
        ->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | PROFILE (current user + other users)
    |--------------------------------------------------------------------------
    */

    // Logged-in user's own profile
    Route::get('/my-profile', [ProfileController::class, 'showMyProfile'])
        ->name('myprofilepage');

    Route::get('/edit-my-profile', [ProfileController::class, 'editMyProfile'])
        ->name('editmyprofilepage');

    Route::patch('/my-profile', [ProfileController::class, 'updateMyProfile'])
        ->name('myprofile.update');

    // Public profile for another user (seller) – Check account button
    Route::get('/users/{user}', [ProfileController::class, 'showPublicProfile'])
        ->name('otherprofilepage');

    // Breeze default profile routes (keep for settings page etc.)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
