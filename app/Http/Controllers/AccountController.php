<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AccountController extends Controller
{
    // My Account Dashboard
    public function index()
    {
        $user = Auth::user();
        return view('my-account.my-account', compact('user'));
    }

    // Profile Settings
    public function profileSettings()
    {
        $user = Auth::user();
        return view('my-account.profile-settings', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_images', 'public');
            $user->profile_picture = basename($path); // Store only filename
        }
        
    
        $user->save();
    
        return back()->with('success', 'Profile updated successfully!');
    }

    public function removeProfilePicture(Request $request)
    {
        $user = auth()->user();
    
        if ($user->profile_picture) {
            // Delete the profile picture from storage
            Storage::disk('public')->delete('profile_images/' . $user->profile_picture);
    
            // Set profile picture to null
            $user->profile_picture = null;
            $user->save();
        }
    
        return redirect()->back()->with('success', 'Profile picture removed successfully.');
    }

    // Address Management
    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses ?? collect([]);

        return view('my-account.addresses', compact('addresses'));
    }

    public function createAddress()
    {
        return view('my-account.create-address');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        Auth::user()->addresses()->create($request->all());

        return redirect()->route('account.addresses')->with('success', 'Address added successfully!');
    }

    public function editAddress($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('my-account.edit-address', compact('address'));
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        $address->update($request->all());

        return redirect()->route('account.addresses')->with('success', 'Address updated successfully!');
    }

    public function destroyAddress($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->delete();

        return redirect()->route('account.addresses')->with('success', 'Address deleted successfully!');
    }
    public function updateAllAddresses(Request $request)
{
    $user = Auth::user();

    foreach ($request->addresses as $id => $data) {
        $address = $user->addresses()->findOrFail($id);
        $address->update($data);
    }

    return redirect()->route('account.addresses')->with('success', 'Addresses updated successfully!');
}

}
