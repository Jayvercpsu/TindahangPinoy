<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_cart_items' => 'required|array',
        ]);

        $productNameErrors = [];
        foreach ($request->selected_cart_items as $cartItemId) {
            $cartItem = Cart::find($cartItemId);
            if ($cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product && $product->stock < $cartItem->quantity) {
                    $productNameErrors[] = $product->name;
                }
            }
        }

        if (!empty($productNameErrors)) {
            return redirect()->route('cart.index')->with('error', 'Cannot place order. Insufficient stock for: ' . implode(', ', $productNameErrors));
        }

        $proofOfPaymentPath = null;

        if ($request->hasFile('proof_of_payment')) {
            $proofOfPaymentPath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
        }

        $selectedCartItems = $request->selected_cart_items;

        $orderNo = strtoupper(Str::random(15));
    
        foreach ($selectedCartItems as $cartItemId) {
            $cartItem = Cart::find($cartItemId);
            if ($cartItem) {
                Order::create([
                    'user_id' => Auth::id(),
                    'order_no' => $orderNo,
                    'product_id' => $cartItem->product_id,
                    'payment_method' => $request->payment_method,
                    'proof_of_payment' => $proofOfPaymentPath,
                    'quantity' => $cartItem->quantity,
                    'total_amount' => $cartItem->product->price * $cartItem->quantity,
                    'status' => 'pending',
                ]);

                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->stock -= $cartItem->quantity;
                    $product->save();
                }
            }
        }

        Cart::where('user_id', Auth::id())
            ->whereIn('id', $selectedCartItems)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}
