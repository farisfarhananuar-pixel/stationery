<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user();
        $totalProducts = $seller->products()->count();
        $totalOrders = $seller->sellerOrders()->count();
        $pendingPayments = $seller->sellerOrders()->where('payment_status', 'receipt_uploaded')->count();
        $totalRevenue = $seller->sellerOrders()->where('payment_status', 'approved')->sum('total_amount');
        $recentOrders = $seller->sellerOrders()->with(['user', 'items'])->latest()->take(5)->get();

        return view('seller.dashboard', compact(
            'totalProducts', 'totalOrders', 'pendingPayments', 'totalRevenue', 'recentOrders'
        ));
    }

    // ---- Products ----
    public function products()
    {
        $products = Auth::user()->products()->with('category')->latest()->paginate(15);
        return view('seller.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('seller.product-form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        $data['seller_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('seller.products')->with('success', 'Product added!');
    }

    public function editProduct(Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);
        $categories = Category::all();
        return view('seller.product-form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('seller.products')->with('success', 'Product updated!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    // ---- Orders ----
    public function orders()
    {
        $orders = Auth::user()->sellerOrders()
            ->with(['user', 'items'])
            ->latest()
            ->paginate(15);
        return view('seller.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);
        $order->load(['user', 'items.product']);
        return view('seller.order-detail', compact('order'));
    }

    public function approvePayment(Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);
        $order->update(['payment_status' => 'approved', 'delivery_status' => 'processing']);
        return back()->with('success', 'Payment approved! Order is now being processed.');
    }

    public function rejectPayment(Request $request, Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);
        $order->update([
            'payment_status' => 'rejected',
            'payment_note' => $request->rejection_reason,
        ]);
        return back()->with('success', 'Payment rejected.');
    }

    public function updateDelivery(Request $request, Order $order)
    {
        if ($order->seller_id !== Auth::id()) abort(403);

        $request->validate([
            'delivery_status' => 'required|in:processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'delivery_note' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['delivery_status', 'tracking_number', 'delivery_note']);
        if ($request->delivery_status === 'delivered') {
            $data['delivered_at'] = now();
        }

        $order->update($data);
        return back()->with('success', 'Delivery status updated!');
    }

    // ---- Profile ----
    public function profile()
    {
        $seller = Auth::user()->load('sellerProfile');
        return view('seller.profile', compact('seller'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'qr_code_image' => 'nullable|image|max:5120',
            'shop_logo' => 'nullable|image|max:5120',
        ]);

        $profile = Auth::user()->sellerProfile;
        $data = $request->only(['shop_name', 'shop_description', 'bank_name', 'bank_account']);

        if ($request->hasFile('qr_code_image')) {
            $data['qr_code_image'] = $request->file('qr_code_image')->store('qr', 'public');
        }
        if ($request->hasFile('shop_logo')) {
            $data['shop_logo'] = $request->file('shop_logo')->store('logos', 'public');
        }

        $profile->update($data);
        return back()->with('success', 'Profile updated!');
    }
}
