<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Customer Login Page
     */
    public function login()
    {
        return view('frontend.login');
    }

    /**
     * Customer Login
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'The email or password is incorrect.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home.index'))
            ->with('success', 'Welcome back!');
    }

    /**
     * Customer Registration Page
     */
    public function register()
    {
        return view('frontend.register');
    }

    /**
     * Customer Registration
     */
    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home.index'))
            ->with('success', 'Account created successfully.');
    }

    /**
     * Customer Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home.index')
            ->with('success', 'You have been logged out successfully.');
    }
}
