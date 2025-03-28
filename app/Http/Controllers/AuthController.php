<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the sign-up form
     */
    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->route('index')->with('message', 'You are already logged in!');
        }
        
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
                'min:8',                        
                'regex:/[A-Z]/',                
                'regex:/[a-z]/',                
                'regex:/[0-9]/',                
                'regex:/[@$!%*?&#]/',           
                'confirmed'
            ],
        ], [
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (@, $, etc.).'
        ]);
    
        try {
            // Store user in database
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            // Redirect back with success message for modal
            return redirect()->route('signup')->with('success', 'Account created successfully! Please log in.');
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            session()->regenerate(); // Ensure session persists after login
    
            return redirect()->route('index')->with('success', 'Welcome back!');
        }
    
        // Use session flash message instead of withErrors()
        return redirect()->route('login')->with('error', 'Invalid email or password.');
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
