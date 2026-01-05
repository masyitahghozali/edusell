<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /*
    |---------------------------------------------------------------
    | Breeze default profile (not your custom UI)
    |---------------------------------------------------------------
    */

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('user_profile_picture')) {
            $filename = time() . '.' . $request->user_profile_picture->extension();
            $request->user_profile_picture->storeAs('public/profile_pictures', $filename);
            $user->user_profile_picture = $filename;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /*
    |---------------------------------------------------------------
    | YOUR CUSTOM PAGES (My profile, Edit profile)
    |---------------------------------------------------------------
    */

    // My Profile (logged-in user)
    public function showMyProfile()
    {
        $user = auth()->user();
        return view('auth.myprofilepage', compact('user'));
    }

    // Edit My Profile
    public function editMyProfile()
    {
        $user = auth()->user();
        return view('auth.editmyprofilepage', compact('user'));
    }

    // Save from Edit My Profile page
    public function updateMyProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                 => 'nullable|string|max:255',
            'user_matric_id'       => 'nullable|string|max:255',
            'user_phone_num'       => 'nullable|string|max:255',
            'user_program'         => 'nullable|string|max:255',
            'user_faculty'         => 'nullable|string|max:255',
            'user_location'        => 'nullable|string|max:255',
            'user_profile_picture' => 'nullable|image|max:4096',
            'user_about'           => 'nullable|string|max:255',
        ]);

        // Update basic info
        $user->name           = $request->name ?? $user->name;
        $user->user_matric_id = $request->user_matric_id;
        $user->user_phone_num = $request->user_phone_num;
        $user->user_program   = $request->user_program;
        $user->user_faculty   = $request->user_faculty;
        $user->user_location  = $request->user_location;
        $user->user_about     = $request->user_about;


        // Handle profile photo
        if ($request->hasFile('user_profile_picture')) {

            // Delete old file
            if ($user->user_profile_picture &&
            \Storage::disk('public')->exists($user->user_profile_picture)) {
            \Storage::disk('public')->delete($user->user_profile_picture);
            }

            // Save new file
            $path = $request->file('user_profile_picture')
                        ->store('profile_pictures', 'public');

            // Save the FULL relative path in DB
            $user->user_profile_picture = $path;
        }

        $user->save();

        return redirect()
            ->route('myprofilepage')
            ->with('success', 'Profile updated successfully.');
    }



    /*
    |---------------------------------------------------------------
    | OTHER USER PUBLIC PROFILE (Check account button)
    |---------------------------------------------------------------
    */

    // /users/{user}
    public function showPublicProfile(User $user)
    {
        // Load this user's items (public listings)
        $items = Item::where('user_id', $user->id)
            ->where('item_status', '!=', 'sold') // optional: hide sold if you want
            ->latest()
            ->get();

        return view('auth.otherprofilepage', compact('user', 'items'));
    }
}
