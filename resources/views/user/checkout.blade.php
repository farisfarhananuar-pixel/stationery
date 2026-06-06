@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="container py-5">
    <h2 class="fw-700 mb-4"><i class="bi bi-bag-check me-2" style="color:#6c63ff;"></i>Checkout</h2>

    <form method="POST" action="{{ route('order.place') }}">
        @csrf
        <div class="row g-4">
            <!-- Shipping Details -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
                    <div class="card-header text-white" style="background:linear-gradient(135deg,#6c63ff,#ff6584);">
                        <h6 class="mb-0 fw-600"><i class="bi bi-geo-alt me-2"></i>Shipping Details</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                            </div>
                        @endif
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-600 small">Full Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" placeholder="012-3456789" value="{{ old('phone', auth()->user()->phone) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small">Shipping Address *</label>
                                <textarea name="shipping_address" class="form-control" rows="3" placeholder="Full address including postcode and state" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="card border-0 shadow-sm" style="border-radius:20px;">
                    <div class="card-header text-white" style="background:linear-gradient(135deg,#43c6ac,#667eea);">
                        <h6 class="mb-0 fw-600"><i class="bi bi-qr-code me-2"></i>Payment Method</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert border-0 p-3 mb-0" style="background:#f0fff8;border-radius:15px;">
                            <h6 class="fw-700 mb-2" style="color:#1a8a6e;">📱 Bank Transfer via QR Code</h6>
                            <ol class="text-muted small mb-0" style="padding-left:1.2rem;line-height:2;">
                                <li>Place your order by clicking <strong>"Place Order"</strong></li>
                                <li>You'll receive a QR code from the seller</li>
                                <li>Scan the QR and transfer the exact amount</li>
                                <li>Upload your payment receipt as proof</li>
                                <li>Seller will verify and approve your payment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm" style="border-radius:20px;position:sticky;top:80px;">
                    <div class="card-header text-white" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
                        <h6 class="mb-0 fw-600"><i class="bi bi-receipt me-2"></i>Order Summary</h6>
                    </div>
                    <div class="card-body p-4">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $item->product->image && !str_starts_with($item->product->image,'http') ? asset('storage/'.$item->product->image) : ($item->product->image ?? 'https://placehold.co/60x60/e8e8ff/6c63ff?text=📦') }}"
                                     style="width:55px;height:55px;object-fit:cover;border-radius:10px;" alt="">
                                <div class="flex-grow-1">
                                    <div class="fw-600 small" style="line-height:1.3;">{{ $item->product->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="fw-600 small">RM {{ number_format($item->product->price * $item->quantity, 2) }}</div>
                            </div>
                        @endforeach
                        <hr>
                        @php $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity); $shipping = $subtotal >= 100 ? 0 : 8; @endphp
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Subtotal</span><span>RM {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Shipping</span>
                            <span>{{ $shipping == 0 ? '<span class="text-success fw-600">FREE</span>' : 'RM '.number_format($shipping, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-700 fs-5">
                            <span>Total</span>
                            <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                                RM {{ number_format($subtotal + $shipping, 2) }}
                            </span>
                        </div>

                        <button type="submit" class="btn w-100 mt-4" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:14px;font-weight:700;font-size:1rem;">
                            <i class="bi bi-bag-check me-2"></i>Place Order
                        </button>
                        <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i>Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
