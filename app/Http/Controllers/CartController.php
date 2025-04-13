<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
 
class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }

        // Fetch user's cart items along with product details
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('cart', ['cart' => $cartItems]);
    }


    public function add(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to cart.');
        }

        $product = Product::findOrFail($request->product_id);

        $quantityToAdd = $request->quantity ?? 1;

        // if stock is 0, return error
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', "Cannot add {$product->name} to cart. Out of stock.");
        }
        
        // Check if requested quantity exceeds available stock
        if ($quantityToAdd > $product->stock) {
            return redirect()->back()->with('error', "Cannot add more than available stock ({$product->stock}) for {$product->name}.");
        }

        $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantityToAdd;

            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', "Adding this quantity exceeds available stock ({$product->stock}) for {$product->name}.");
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantityToAdd
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} added to cart!");
    }

    public function remove($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to remove items.');
        }

        // Find the cart item belonging to the logged-in user
        $cartItem = Cart::where('user_id', auth()->id())->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
    }

    public function clear()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to clear your cart.');
        }

        // Delete all cart items for the logged-in user
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    public function buyNow(Request $request)
    {
        $selectedItems = explode(',', $request->input('selected_items', '')); 
        $quantities = explode(',', $request->input('quantities', '')); 
        $cartItems = Cart::where('user_id', auth()->id())->whereIn('id', $selectedItems)->with('product')->get();

        foreach ($cartItems as $index => $cartItem) {
            $product = $cartItem->product;
            $quantity = isset($quantities[$index]) ? (int)$quantities[$index] : $cartItem->quantity;

            if ($quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', "Insufficient stock for {$product->name}.");
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $address = auth()->user()->address;

        return view('cart.buy-now', compact('cartItems', 'address'));
    }
}
