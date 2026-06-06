@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="container py-5">
    <h2 class="fw-700 mb-4"><i class="bi bi-bag-check me-2" style="color:#6c63ff;"></i>My Orders</h2>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem;">📦</div>
            <h4 class="mt-3 text-muted">No orders yet</h4>
            <a href="{{ route('shop') }}" class="btn mt-3" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:12px 30px;font-weight:600;">Start Shopping</a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2" style="background:#f8f7ff;border-bottom:2px solid #eee;">
                        <div>
                            <span class="fw-700" style="color:#6c63ff;">{{ $order->order_number }}</span>
                            <span class="text-muted small ms-3"><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            {!! $order->paymentStatusBadge() !!}
                            {!! $order->deliveryStatusBadge() !!}
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-shop text-muted"></i>
                                    <span class="fw-600 small">{{ $order->seller->sellerProfile->shop_name ?? $order->seller->name }}</span>
                                </div>
                                <div class="text-muted small">
                                    {{ $order->items->count() }} item(s): {{ $order->items->pluck('product_name')->implode(', ') }}
                                </div>
                            </div>
                            <div class="col-md-3 text-md-center">
                                <div class="text-muted small">Total Amount</div>
                                <div class="fw-700 fs-5" style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                                    RM {{ number_format($order->total_amount, 2) }}
                                </div>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <a href="{{ route('user.order.detail', $order) }}" class="btn btn-sm" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:8px 20px;font-weight:600;">
                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
