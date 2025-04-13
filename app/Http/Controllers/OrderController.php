<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function viewOrders(Request $request)
    {
        $entries = $request->get('entries', 5);
        $query = $this->applySearchFilters(Order::with('user')->orderBy('id', 'desc'), $request);

        $orders = $query->paginate($entries);

        return view('admin.view-orders', compact('orders'));
    }

    public function pendingOrders(Request $request)
    {
        $entries = $request->get('entries', 5);
        $query = $this->applySearchFilters(Order::with('user')->orderBy('id', 'desc'), $request);

        $orders = $query->where('status', '!=', 'delivered')->paginate($entries);
        $newOrdersCount = Order::where('status', 'pending')->count();
        $aprovedOrdersCount = Order::where('status', 'approved')->count();
        $readyToShipOrdersCount = Order::where('status', 'in progress')->count();
        $shippedOrdersCount = Order::where('status', 'delivered')->count();

        return view('admin.pending-orders', compact('orders', 'newOrdersCount', 'aprovedOrdersCount', 'readyToShipOrdersCount', 'shippedOrdersCount'));
    }

    public function completedOrders(Request $request)
    {
        $entries = $request->get('entries', 5);
        $query = $this->applySearchFilters(Order::with('user')->orderBy('id', 'desc'), $request);

        $orders = $query->where('status', 'delivered')->paginate($entries);

        // Group completed orders by month and count them
        $monthlyCompletedOrders = Order::where('status', 'delivered')
            ->selectRaw('DATE_FORMAT(updated_at, "%b %Y") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderByRaw('MIN(updated_at)')
            ->pluck('count', 'month');

        return view('admin.completed-orders', compact('orders', 'monthlyCompletedOrders'));
    }

    public function generateInvoice($orderNo)
    {
        $order = Order::with('user', 'product')->where('order_no', $orderNo)->firstOrFail();

        // Render the Blade view as HTML
        $html = view('invoices.order-invoice', compact('order'))->render();

        // Initialize Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Set paper size and orientation
        $dompdf->render();

        // Return the generated PDF as a download
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice-' . $order->order_no . '.pdf"',
        ]);
    }

    public function deleteOrder($id)
    {
        try {
            $order = Order::where('id', $id)->firstOrFail();

            // Perform deletion
            $order->delete();

            return redirect()->route('admin.view-orders')->with('success', 'Order deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.view-orders')->with('error', 'Order not found.');
        } catch (\Exception $e) {
            // Optional: handle other unexpected errors
            return redirect()->route('admin.view-orders')->with('error', 'An error occurred while deleting the order.');
        }
    }

    public function approveOrder($id)
    {
        try {
            $order = Order::where('id', $id)->firstOrFail();
            
            // Update to approved status
            $order->update(['status' => 'approved']);

            // Schedule status change to 'in progress' after 1 second
            sleep(1);
            $order->update(['status' => 'in progress']);

            return response()->json([
                'success' => true,
                'message' => 'Order approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error approving order'
            ], 500);
        }
    }

    public function completeOrder($id)
    {
        try {
            $order = Order::where('id', $id)->where('status', 'in progress')->firstOrFail();
            
            // Update to delivered status
            $order->update([
                'status' => 'delivered',
                'tracking_number' => request('tracking_number'),
                'completion_notes' => request('completion_notes')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order marked as complete successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or cannot be completed'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing order'
            ], 500);
        }
    }

    /**
     * Apply search filters to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applySearchFilters($query, Request $request)
    {
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', '%' . $search . '%')
                  ->orWhere('created_at', 'like', '%' . $search . '%')
                  ->orWhere('total_amount', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        return $query;
    }
}
