@extends('layouts.dashboard')
@section('title', 'Seller Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-1">
            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
            <div class="stat-number">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-2">
            <div class="stat-icon"><i class="bi bi-bag-check"></i></div>
            <div class="stat-number">{{ $totalOrders }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-3">
            <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
            <div class="stat-number">{{ $pendingPayments }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-4">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-number">RM {{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card-custom card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Recent Orders</span>
                <a href="{{ route('seller.orders') }}" class="btn btn-sm btn-outline-light rounded-pill">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Delivery</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td><span class="fw-600" style="color:#6c63ff;">{{ $order->order_number }}</span></td>
                                    <td>{{ $order->user->name }}</td>
                                    <td class="fw-600">RM {{ number_format($order->total_amount, 2) }}</td>
                                    <td>{!! $order->paymentStatusBadge() !!}</td>
                                    <td>{!! $order->deliveryStatusBadge() !!}</td>
                                    <td>
                                        <a href="{{ route('seller.order.detail', $order) }}" class="btn btn-sm btn-grad">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No orders yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card-custom card mb-4">
            <div class="card-header"><i class="bi bi-lightning me-2"></i>Quick Actions</div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('seller.products.create') }}" class="btn btn-grad w-100">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </a>
                    <a href="{{ route('seller.orders') }}" class="btn btn-outline-grad w-100">
                        <i class="bi bi-bag-check me-2"></i>View Orders
                    </a>
                    <a href="{{ route('seller.profile') }}" class="btn btn-outline-grad w-100">
                        <i class="bi bi-qr-code me-2"></i>Upload QR Code
                    </a>
                </div>
            </div>
        </div>

        @php $profile = auth()->user()->sellerProfile; @endphp
        @if($profile && !$profile->qr_code_image)
            <div class="alert border-0 p-3" style="background:#fff8e1;border-radius:15px;">
                <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                <strong>Action Required!</strong> Upload your QR code so customers can pay you.
                <a href="{{ route('seller.profile') }}" class="d-block mt-2 fw-600 small" style="color:#6c63ff;">Go to Profile →</a>
            </div>
        @endif
    </div>
</div>
@endsection
