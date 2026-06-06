@extends('layouts.app')
@section('title', 'Order '.$order->order_number)
@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <h3 class="fw-700 mb-0">Order {{ $order->order_number }}</h3>
    </div>

    <div class="row g-4">
        <!-- Left: Items + Shipping -->
        <div class="col-lg-8">
            <!-- Items -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;overflow:hidden;">
                <div class="card-header text-white" style="background:linear-gradient(135deg,#6c63ff,#ff6584);">
                    <h6 class="mb-0 fw-600"><i class="bi bi-bag me-2"></i>Order Items</h6>
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                        <div class="p-4 d-flex align-items-center gap-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <img src="{{ $item->product->image && !str_starts_with($item->product->image,'http') ? asset('storage/'.$item->product->image) : ($item->product->image ?? 'https://placehold.co/70x70/e8e8ff/6c63ff?text=📦') }}"
                                 style="width:70px;height:70px;object-fit:cover;border-radius:12px;">
                            <div class="flex-grow-1">
                                <div class="fw-600">{{ $item->product_name }}</div>
                                <div class="text-muted small">RM {{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                            </div>
                            <div class="fw-700">RM {{ number_format($item->subtotal, 2) }}</div>
                        </div>
                    @endforeach
                    <div class="p-4 bg-light d-flex justify-content-between fw-700 fs-5">
                        <span>Total</span>
                        <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                            RM {{ number_format($order->total_amount, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
                <div class="card-body p-4">
                    <h6 class="fw-700 mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Shipping Information</h6>
                    <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- Payment Receipt Upload -->
            @if($order->payment_status === 'pending' || $order->payment_status === 'rejected')
                <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                    <div class="card-header text-white" style="background:linear-gradient(135deg,#43c6ac,#667eea);">
                        <h6 class="mb-0 fw-600"><i class="bi bi-upload me-2"></i>Upload Payment Receipt</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($order->payment_status === 'rejected')
                            <div class="alert border-0 mb-4" style="background:#ffe0e7;border-radius:12px;color:#c0392b;">
                                <i class="bi bi-x-circle me-2"></i>
                                <strong>Previous payment rejected.</strong>
                                @if($order->payment_note) Reason: {{ $order->payment_note }} @endif
                                Please upload a new receipt.
                            </div>
                        @endif

                        <!-- Show Seller QR -->
                        @if($order->seller->sellerProfile && $order->seller->sellerProfile->qr_code_image)
                            <div class="text-center mb-4 p-4 rounded-3" style="background:#f8f7ff;">
                                <h6 class="fw-700 mb-3">📱 Scan to Pay</h6>
                                <img src="{{ asset('storage/'.$order->seller->sellerProfile->qr_code_image) }}"
                                     style="max-width:220px;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.1);" alt="QR Code">
                                <div class="mt-3 text-muted small">
                                    <div><strong>Bank:</strong> {{ $order->seller->sellerProfile->bank_name ?? 'N/A' }}</div>
                                    <div><strong>Account:</strong> {{ $order->seller->sellerProfile->bank_account ?? 'N/A' }}</div>
                                </div>
                                <div class="mt-2 fw-700 fs-5" style="color:#6c63ff;">Transfer: RM {{ number_format($order->total_amount, 2) }}</div>
                            </div>
                        @else
                            <div class="alert border-0 mb-4" style="background:#fff8e1;border-radius:12px;">
                                <i class="bi bi-info-circle me-2"></i>Contact seller for bank account details.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('order.upload.receipt', $order) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Amount Transferred (RM) *</label>
                                    <input type="number" name="amount_transferred" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ $order->total_amount }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Receipt Image *</label>
                                    <input type="file" name="receipt_image" class="form-control" accept="image/*" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-600 small">Note (Optional)</label>
                                    <input type="text" name="payment_note" class="form-control" placeholder="e.g. Transfer reference number">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:12px 30px;font-weight:600;">
                                        <i class="bi bi-upload me-2"></i>Submit Receipt
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Uploaded Receipt -->
            @if($order->receipt_image && in_array($order->payment_status, ['receipt_uploaded','approved','rejected']))
                <div class="card border-0 shadow-sm mt-4" style="border-radius:20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-700 mb-3"><i class="bi bi-receipt me-2 text-success"></i>Submitted Receipt</h6>
                        <img src="{{ asset('storage/'.$order->receipt_image) }}" style="max-width:300px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);" alt="Receipt">
                        <div class="mt-2 text-muted small">
                            Amount transferred: <strong>RM {{ number_format($order->amount_transferred, 2) }}</strong>
                            @if($order->payment_note) | Note: {{ $order->payment_note }} @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Status -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius:20px;position:sticky;top:80px;">
                <div class="card-body p-4">
                    <h6 class="fw-700 mb-4">Order Status</h6>

                    <!-- Seller Info -->
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#f8f7ff;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700" style="width:45px;height:45px;background:linear-gradient(135deg,#6c63ff,#ff6584);flex-shrink:0;">
                            {{ strtoupper(substr($order->seller->sellerProfile->shop_name ?? $order->seller->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-600 small">{{ $order->seller->sellerProfile->shop_name ?? $order->seller->name }}</div>
                            <div class="text-muted" style="font-size:0.7rem;"><i class="bi bi-shop me-1"></i>Seller</div>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="timeline">
                        @php
                            $paySteps = [
                                'pending' => ['label'=>'Order Placed','icon'=>'bi-bag-check','done'=>true],
                                'receipt_uploaded' => ['label'=>'Receipt Uploaded','icon'=>'bi-upload','done'=>in_array($order->payment_status,['receipt_uploaded','approved'])],
                                'approved' => ['label'=>'Payment Approved','icon'=>'bi-check-circle','done'=>$order->payment_status==='approved'],
                            ];
                            $delSteps = [
                                'processing' => ['label'=>'Processing','icon'=>'bi-gear','done'=>in_array($order->delivery_status,['processing','shipped','delivered'])],
                                'shipped' => ['label'=>'Shipped','icon'=>'bi-truck','done'=>in_array($order->delivery_status,['shipped','delivered'])],
                                'delivered' => ['label'=>'Delivered','icon'=>'bi-house-check','done'=>$order->delivery_status==='delivered'],
                            ];
                        @endphp

                        <p class="text-muted small fw-600 mb-2">Payment</p>
                        @foreach($paySteps as $step)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:35px;height:35px;flex-shrink:0;background:{{ $step['done'] ? 'linear-gradient(135deg,#43c6ac,#667eea)' : '#e0e0e0' }}">
                                    <i class="bi {{ $step['icon'] }} small"></i>
                                </div>
                                <span class="small {{ $step['done'] ? 'fw-600' : 'text-muted' }}">{{ $step['label'] }}</span>
                            </div>
                        @endforeach

                        @if($order->payment_status === 'approved')
                            <p class="text-muted small fw-600 mb-2 mt-3">Delivery</p>
                            @foreach($delSteps as $step)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:35px;height:35px;flex-shrink:0;background:{{ $step['done'] ? 'linear-gradient(135deg,#6c63ff,#ff6584)' : '#e0e0e0' }}">
                                        <i class="bi {{ $step['icon'] }} small"></i>
                                    </div>
                                    <span class="small {{ $step['done'] ? 'fw-600' : 'text-muted' }}">{{ $step['label'] }}</span>
                                </div>
                            @endforeach
                            @if($order->tracking_number)
                                <div class="mt-2 p-2 rounded" style="background:#f0fff8;">
                                    <small class="text-muted">Tracking: <strong>{{ $order->tracking_number }}</strong></small>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Payment Status</span>
                            {!! $order->paymentStatusBadge() !!}
                        </div>
                        <div class="d-flex justify-content-between small mt-2">
                            <span class="text-muted">Delivery Status</span>
                            {!! $order->deliveryStatusBadge() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
