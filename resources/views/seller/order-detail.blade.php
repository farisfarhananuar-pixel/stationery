@extends('layouts.dashboard')
@section('title', 'Order '.$order->order_number)
@section('page-title', 'Order Detail')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('seller.orders') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
    <h5 class="mb-0 fw-700">{{ $order->order_number }}</h5>
    {!! $order->paymentStatusBadge() !!}
    {!! $order->deliveryStatusBadge() !!}
</div>

<div class="row g-4">
    <!-- Left: Items + Customer -->
    <div class="col-lg-7">
        <!-- Order Items -->
        <div class="card-custom card mb-4">
            <div class="card-header"><i class="bi bi-bag me-2"></i>Order Items</div>
            <div class="card-body p-0">
                @foreach($order->items as $item)
                    <div class="p-4 d-flex align-items-center gap-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ $item->product->image && !str_starts_with($item->product->image,'http') ? asset('storage/'.$item->product->image) : ($item->product->image ?? 'https://placehold.co/60x60/e8e8ff/6c63ff?text=📦') }}"
                             style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                        <div class="flex-grow-1">
                            <div class="fw-600">{{ $item->product_name }}</div>
                            <div class="text-muted small">RM {{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                        </div>
                        <div class="fw-700">RM {{ number_format($item->subtotal, 2) }}</div>
                    </div>
                @endforeach
                <div class="p-4 d-flex justify-content-between fw-700 fs-5" style="background:#f8f7ff;">
                    <span>Total</span>
                    <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                        RM {{ number_format($order->total_amount, 2) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card-custom card mb-4">
            <div class="card-header"><i class="bi bi-person me-2"></i>Customer Details</div>
            <div class="card-body p-4">
                <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $order->phone }}</p>
                <p class="mb-0"><strong>Address:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Payment Receipt -->
        @if($order->receipt_image)
            <div class="card-custom card mb-4">
                <div class="card-header"><i class="bi bi-receipt me-2"></i>Payment Receipt</div>
                <div class="card-body p-4">
                    <div class="row g-3 align-items-start">
                        <div class="col-md-5">
                            <img src="{{ asset('storage/'.$order->receipt_image) }}" class="img-fluid rounded-3 shadow-sm" alt="Receipt" style="max-height:280px;object-fit:contain;">
                        </div>
                        <div class="col-md-7">
                            <div class="p-3 rounded-3 mb-3" style="background:#f8f7ff;">
                                <div class="mb-2"><strong>Amount Transferred:</strong></div>
                                <div class="fs-4 fw-700" style="color:#43c6ac;">RM {{ number_format($order->amount_transferred, 2) }}</div>
                                <div class="text-muted small mt-1">
                                    <strong>Expected:</strong> RM {{ number_format($order->total_amount, 2) }}
                                    @if($order->amount_transferred >= $order->total_amount)
                                        <span class="text-success ms-2"><i class="bi bi-check-circle"></i> Amount matches</span>
                                    @else
                                        <span class="text-danger ms-2"><i class="bi bi-exclamation-circle"></i> Amount short</span>
                                    @endif
                                </div>
                                @if($order->payment_note)
                                    <div class="text-muted small mt-2"><strong>Note:</strong> {{ $order->payment_note }}</div>
                                @endif
                            </div>

                            @if($order->payment_status === 'receipt_uploaded')
                                <div class="d-flex flex-column gap-2">
                                    <form method="POST" action="{{ route('seller.order.approve', $order) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-grad w-100"
                                                onclick="return confirm('Approve this payment?')">
                                            <i class="bi bi-check-circle me-2"></i>Approve Payment
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-outline-danger rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="bi bi-x-circle me-2"></i>Reject Payment
                                    </button>
                                </div>
                            @elseif($order->payment_status === 'approved')
                                <div class="alert border-0" style="background:#d4f5ed;color:#1a8a6e;border-radius:12px;">
                                    <i class="bi bi-check-circle-fill me-2"></i>Payment Approved
                                </div>
                            @elseif($order->payment_status === 'rejected')
                                <div class="alert border-0" style="background:#ffe0e7;color:#c0392b;border-radius:12px;">
                                    <i class="bi bi-x-circle-fill me-2"></i>Payment Rejected
                                    @if($order->payment_note) <br><small>Reason: {{ $order->payment_note }}</small> @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->payment_status === 'pending')
            <div class="alert border-0" style="background:#fff8e1;border-radius:15px;">
                <i class="bi bi-clock me-2"></i>Waiting for customer to upload payment receipt.
            </div>
        @endif
    </div>

    <!-- Right: Delivery -->
    <div class="col-lg-5">
        <div class="card-custom card" style="position:sticky;top:80px;">
            <div class="card-header"><i class="bi bi-truck me-2"></i>Delivery Management</div>
            <div class="card-body p-4">
                @if($order->payment_status !== 'approved')
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-lock fs-3 mb-2 d-block"></i>
                        Delivery management is available after payment approval.
                    </div>
                @else
                    <div class="mb-4">
                        <div class="fw-700 small mb-2">Current Status:</div>
                        {!! $order->deliveryStatusBadge() !!}
                        @if($order->tracking_number)
                            <div class="mt-2 p-2 rounded" style="background:#f8f7ff;">
                                <small class="text-muted">Tracking: <strong>{{ $order->tracking_number }}</strong></small>
                            </div>
                        @endif
                        @if($order->delivery_note)
                            <div class="mt-2 text-muted small">Note: {{ $order->delivery_note }}</div>
                        @endif
                    </div>

                    @if($order->delivery_status !== 'delivered' && $order->delivery_status !== 'cancelled')
                        <form method="POST" action="{{ route('seller.order.delivery', $order) }}">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-600 small">Update Status</label>
                                <select name="delivery_status" class="form-select" required>
                                    <option value="processing" {{ $order->delivery_status=='processing'?'selected':'' }}>🔧 Processing</option>
                                    <option value="shipped" {{ $order->delivery_status=='shipped'?'selected':'' }}>🚚 Shipped</option>
                                    <option value="delivered" {{ $order->delivery_status=='delivered'?'selected':'' }}>✅ Delivered</option>
                                    <option value="cancelled">❌ Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-600 small">Tracking Number</label>
                                <input type="text" name="tracking_number" class="form-control" placeholder="e.g. POS123456789" value="{{ $order->tracking_number }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-600 small">Delivery Note</label>
                                <textarea name="delivery_note" class="form-control" rows="2" placeholder="e.g. Handed to Pos Malaysia">{{ $order->delivery_note }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-grad w-100">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Delivery
                            </button>
                        </form>
                    @else
                        <div class="text-center py-3">
                            @if($order->delivery_status === 'delivered')
                                <div style="font-size:3rem;">🎉</div>
                                <div class="fw-700 mt-2 text-success">Order Delivered!</div>
                                @if($order->delivered_at)
                                    <div class="text-muted small mt-1">{{ $order->delivered_at->format('d M Y, h:i A') }}</div>
                                @endif
                            @else
                                <div style="font-size:3rem;">❌</div>
                                <div class="fw-700 mt-2 text-danger">Order Cancelled</div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#ff6584,#ff9eb5);border-radius:20px 20px 0 0;">
                <h5 class="modal-title text-white fw-700"><i class="bi bi-x-circle me-2"></i>Reject Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('seller.order.reject', $order) }}">
                @csrf
                <div class="modal-body p-4">
                    <label class="form-label fw-600 small">Reason for Rejection *</label>
                    <textarea name="rejection_reason" class="form-control" rows="3" placeholder="e.g. Wrong amount transferred, blurry receipt..." required></textarea>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background:linear-gradient(135deg,#ff6584,#ff9eb5);color:#fff;border-radius:50px;padding:8px 24px;font-weight:600;">
                        Reject Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
