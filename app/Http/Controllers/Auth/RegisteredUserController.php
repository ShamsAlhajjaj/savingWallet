<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet; // Import Wallet model
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|unique:users',
            'birthdate' => 'nullable|date',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'required|image|max:5120|mimes:jpeg,png,jpg,gif',
        ]);
        $imagePath = public_path('images');
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }
        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($imagePath, $imageName);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'password' => Hash::make($request->password),
            'image' => $imageName,
        ]);

        // Automatically create a wallet for the user with an initial balance of 0
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0, // Default initial balance
        ]);

        // Fire the registered event
        event(new Registered($user));

        // Log in the newly registered user
        Auth::login($user);

        // Redirect to the user's dashboard or any other intended route
        return redirect(route('dashboard'));
    }
}
