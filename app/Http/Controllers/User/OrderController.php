<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::with('product.seller.sellerProfile')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Group by seller
        $sellerGroups = $cartItems->groupBy('product.seller_id');

        return view('user.checkout', compact('cartItems', 'sellerGroups'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cartItems = Cart::with('product.seller')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Cart is empty.');
        }

        // Group by seller and create separate orders
        $sellerGroups = $cartItems->groupBy('product.seller_id');

        DB::transaction(function () use ($sellerGroups, $request) {
            foreach ($sellerGroups as $sellerId => $items) {
                $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => Auth::id(),
                    'seller_id' => $sellerId,
                    'total_amount' => $total,
                    'shipping_address' => $request->shipping_address,
                    'phone' => $request->phone,
                    'payment_status' => 'pending',
                    'delivery_status' => 'pending',
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->product->price * $item->quantity,
                    ]);

                    // Reduce stock
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        });

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success', 'Order placed! Please upload payment receipt.');
    }

    public function myOrders()
    {
        $orders = Order::with(['items', 'seller.sellerProfile'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load(['items.product', 'seller.sellerProfile']);
        return view('user.order-detail', compact('order'));
    }

    public function uploadReceipt(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        $request->validate([
            'receipt_image' => 'required|image|max:5120',
            'amount_transferred' => 'required|numeric|min:0',
            'payment_note' => 'nullable|string|max:500',
        ]);

        $path = $request->file('receipt_image')->store('receipts', 'public');

        $order->update([
            'receipt_image' => $path,
            'amount_transferred' => $request->amount_transferred,
            'payment_note' => $request->payment_note,
            'payment_status' => 'receipt_uploaded',
        ]);

        return back()->with('success', 'Receipt uploaded! Waiting for seller approval.');
    }
}
