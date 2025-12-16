<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.registerpage');
    }

    public function store(Request $request): RedirectResponse
    {
        // ✅ only email + password + confirmation
        $request->validate([
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'                 => null,                // 👈 leave empty
            'email'                => $request->email,
            'password'             => Hash::make($request->password),

            // profile fields will be filled later
            'user_matric_id'       => null,
            'user_phone_num'       => null,
            'user_program'         => null,
            'user_faculty'         => null,
            'user_location'        => null,
            'user_profile_picture' => null,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
