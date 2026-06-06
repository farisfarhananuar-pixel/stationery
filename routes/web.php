<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Admin\AdminController;

// ==============================
// PUBLIC ROUTES
// ==============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/website-owner', [HomeController::class, 'websiteOwner'])->name('website.owner');

// ==============================
// AUTH ROUTES
// ==============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==============================
// USER ROUTES
// ==============================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('user.orders');
    Route::get('/my-orders/{order}', [OrderController::class, 'orderDetail'])->name('user.order.detail');
    Route::post('/my-orders/{order}/receipt', [OrderController::class, 'uploadReceipt'])->name('order.upload.receipt');
});

// ==============================
// SELLER ROUTES
// ==============================
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/pending', fn() => view('seller.pending'))->name('pending');
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');

    Route::get('/products', [SellerController::class, 'products'])->name('products');
    Route::get('/products/create', [SellerController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [SellerController::class, 'deleteProduct'])->name('products.delete');

    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [SellerController::class, 'orderDetail'])->name('order.detail');
    Route::post('/orders/{order}/approve', [SellerController::class, 'approvePayment'])->name('order.approve');
    Route::post('/orders/{order}/reject', [SellerController::class, 'rejectPayment'])->name('order.reject');
    Route::put('/orders/{order}/delivery', [SellerController::class, 'updateDelivery'])->name('order.delivery');
});

// ==============================
// ADMIN ROUTES
// ==============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers');
    Route::post('/sellers/{user}/approve', [AdminController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/sellers/{user}/reject', [AdminController::class, 'rejectSeller'])->name('sellers.reject');
    Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
});
