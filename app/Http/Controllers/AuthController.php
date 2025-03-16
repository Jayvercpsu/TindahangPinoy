<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the sign-up form
     */
    public function showSignup()
    {
        return view('auth.signup');
    }

    /**
     * Handle user sign-up
     */
    public function signup(Request $request)
    {
        // Validate input with strong password rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',                        // Minimum 8 characters
                'regex:/[A-Z]/',                // At least one uppercase letter
                'regex:/[a-z]/',                // At least one lowercase letter
                'regex:/[0-9]/',                // At least one number
                'regex:/[@$!%*?&#]/',           // At least one special character
                'confirmed'
            ],
        ], [
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (@, $, etc.).'
        ]);

        try {
            // Store user in database
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Auto login the user after sign-up
            Auth::login($user);

            // Redirect back with success flag for modal
            return redirect()->route('signup')->with('success', 'Account created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('signup')->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return redirect()->route('index')->with('success', 'Logged in successfully!');
        }

        // If login fails, return with error message
        return back()->withErrors(['login' => 'Invalid email or password'])->withInput();
    }


    /**
     * Handle user logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
