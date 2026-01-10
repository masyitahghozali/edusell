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

    /*
    |--------------------------------------------------------------------------
    | MAIN HOMEPAGE
    |--------------------------------------------------------------------------
    */

    Route::get('/homepage', function (Request $request) {
        $search   = $request->get('q');
        $category = $request->get('category');

        $query = Item::with('user')
            ->where('item_status', '!=', 'sold')
            ->where('user_id', '!=', auth()->id())
            ->latest();

        if (!empty($search)) {
            $query->where('item_name', 'like', "%{$search}%");
        }

        if (!empty($category) && $category !== 'all') {
            $query->where('item_category', $category);
        }

        $items = $query->get();

        return view('auth.homepage', compact('items', 'search', 'category'));
    })->name('homepage');

    // Breeze dashboard redirect
    Route::get('/dashboard', fn () => redirect()->route('homepage'))
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ITEMS
    |--------------------------------------------------------------------------
    */

    Route::get('/sell-item', [ItemController::class, 'create'])
        ->name('sellitempage');

    Route::post('/items', [ItemController::class, 'store'])
        ->name('items.store');

    Route::get('/my-listings', [ItemController::class, 'index'])
        ->name('listingpage');

    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])
        ->name('items.edit');

    Route::put('/items/{item}', [ItemController::class, 'update'])
        ->name('items.update');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])
        ->name('items.destroy');

    Route::get('/items/{item}', [ItemController::class, 'show'])
        ->name('itemdetailpage');

    Route::post('/items/{item}/toggle-like', [ItemController::class, 'toggleLike'])
        ->name('items.toggle-like');

    Route::get('/likes', [ItemController::class, 'likedItems'])
        ->name('likeitempage');

    /*
    |--------------------------------------------------------------------------
    | INBOX + CHAT  ✅ FINAL & STABLE
    |--------------------------------------------------------------------------
    */

    // Inbox
    Route::get('/inbox', [ChatController::class, 'inbox'])
        ->name('inboxpage');

    // Chat page (Route Model Binding)
    Route::get('/chat/{user}/{item}', [ChatController::class, 'show'])
        ->name('chatpage');

    // Send message
    Route::post('/chat/{user}/{item}', [ChatController::class, 'send'])
        ->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/my-profile', [ProfileController::class, 'showMyProfile'])
        ->name('myprofilepage');

    Route::get('/edit-my-profile', [ProfileController::class, 'editMyProfile'])
        ->name('editmyprofilepage');

    Route::patch('/my-profile', [ProfileController::class, 'updateMyProfile'])
        ->name('myprofile.update');

    Route::get('/users/{user}', [ProfileController::class, 'showPublicProfile'])
        ->name('otherprofilepage');

    /*
    |--------------------------------------------------------------------------
    | Breeze default profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
