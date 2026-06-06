@extends('layouts.app')
@section('title', 'My Cart')
@section('content')
<div class="container py-5">
    <h2 class="fw-700 mb-4"><i class="bi bi-cart3 me-2" style="color:#6c63ff;"></i>My Shopping Cart</h2>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem;">🛒</div>
            <h4 class="mt-3 text-muted">Your cart is empty</h4>
            <p class="text-muted">Add some awesome stationery to get started!</p>
            <a href="{{ route('shop') }}" class="btn mt-2" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:12px 30px;font-weight:600;">Browse Shop</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                    <div class="card-header text-white" style="background:linear-gradient(135deg,#6c63ff,#ff6584);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-600"><i class="bi bi-bag me-2"></i>{{ $cartItems->count() }} Item(s)</span>
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-light rounded-pill">
                                    <i class="bi bi-trash me-1"></i>Clear All
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                            <div class="p-4 d-flex align-items-center gap-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <img src="{{ $item->product->image && !str_starts_with($item->product->image,'http') ? asset('storage/'.$item->product->image) : ($item->product->image ?? 'https://placehold.co/80x80/e8e8ff/6c63ff?text=📦') }}"
                                     style="width:80px;height:80px;object-fit:cover;border-radius:12px;" alt="{{ $item->product->name }}">
                                <div class="flex-grow-1">
                                    <h6 class="fw-600 mb-1">{{ $item->product->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $item->product->seller->sellerProfile->shop_name ?? $item->product->seller->name }}</p>
                                    <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:700;">
                                        RM {{ number_format($item->product->price, 2) }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="d-flex align-items-center gap-1">
                                        @csrf @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                               class="form-control text-center" style="width:70px;border-radius:10px;" onchange="this.form.submit()">
                                    </form>
                                    <div class="text-end">
                                        <div class="fw-700">RM {{ number_format($item->product->price * $item->quantity, 2) }}</div>
                                        <form method="POST" action="{{ route('cart.remove', $item) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger p-0 mt-1">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="border-radius:20px;position:sticky;top:80px;">
                    <div class="card-body p-4">
                        <h5 class="fw-700 mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span>RM {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Shipping</span>
                            <span>{{ $total >= 100 ? '<span class="text-success">FREE</span>' : 'RM 8.00' }}</span>
                        </div>
                        @if($total < 100)
                            <div class="alert py-2 px-3 mb-2" style="background:#fff8e1;border-radius:10px;font-size:0.8rem;border:none;">
                                <i class="bi bi-info-circle me-1"></i>Add RM {{ number_format(100 - $total, 2) }} more for free shipping!
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-700 fs-5">
                            <span>Total</span>
                            <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                                RM {{ number_format($total >= 100 ? $total : $total + 8, 2) }}
                            </span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn w-100 mt-4" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:14px;font-weight:700;font-size:1rem;">
                            Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
