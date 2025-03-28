<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.all-users', compact('users'));
    }

    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.all-users')->with('success', 'User deleted successfully.');
    }
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

    return back()->withErrors(['email' => 'Invalid credentials']);
}

}
