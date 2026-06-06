<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'approved')->sum('total_amount');
        $pendingSellers = SellerProfile::where('status', 'pending')->count();
        $recentOrders = Order::with(['user', 'seller'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts',
            'totalOrders', 'totalRevenue', 'pendingSellers', 'recentOrders'
        ));
    }

    public function users()
    {
        $users = User::where('role', 'user')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function sellers()
    {
        $sellers = User::where('role', 'seller')->with('sellerProfile')->latest()->paginate(20);
        return view('admin.sellers', compact('sellers'));
    }

    public function approveSeller(User $user)
    {
        $user->sellerProfile->update(['status' => 'approved']);
        return back()->with('success', 'Seller approved!');
    }

    public function rejectSeller(User $user)
    {
        $user->sellerProfile->update(['status' => 'rejected']);
        return back()->with('success', 'Seller rejected.');
    }

    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated.');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'seller'])->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'icon' => 'nullable|string|max:50']);
        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'icon' => $request->icon ?? '📦',
        ]);
        return back()->with('success', 'Category added!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
