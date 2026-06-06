@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-1">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Total Customers</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-2">
            <div class="stat-icon"><i class="bi bi-shop"></i></div>
            <div class="stat-number">{{ $totalSellers }}</div>
            <div class="stat-label">Total Sellers
                @if($pendingSellers > 0)
                    <span class="badge bg-white text-dark ms-1">{{ $pendingSellers }} pending</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-3">
            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
            <div class="stat-number">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-4">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-number">RM{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Recent Orders</span>
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-light rounded-pill">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Seller</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Delivery</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td><span class="fw-600" style="color:#6c63ff;">{{ $order->order_number }}</span></td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->seller->name }}</td>
                                    <td class="fw-600">RM {{ number_format($order->total_amount, 2) }}</td>
                                    <td>{!! $order->paymentStatusBadge() !!}</td>
                                    <td>{!! $order->deliveryStatusBadge() !!}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4 text-muted">No orders yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom card mb-4">
            <div class="card-header"><i class="bi bi-lightning me-2"></i>Quick Actions</div>
            <div class="card-body p-4 d-flex flex-column gap-2">
                <a href="{{ route('admin.sellers') }}" class="btn btn-grad w-100">
                    <i class="bi bi-shop me-2"></i>Manage Sellers
                    @if($pendingSellers > 0)
                        <span class="badge bg-white text-dark ms-1">{{ $pendingSellers }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-grad w-100">
                    <i class="bi bi-people me-2"></i>Manage Users
                </a>
                <a href="{{ route('admin.categories') }}" class="btn btn-outline-grad w-100">
                    <i class="bi bi-tags me-2"></i>Manage Categories
                </a>
            </div>
        </div>

        <div class="card-custom card">
            <div class="card-header"><i class="bi bi-bar-chart me-2"></i>Overview</div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Total Orders</span>
                    <span class="fw-600">{{ $totalOrders }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Pending Sellers</span>
                    <span class="fw-600 text-warning">{{ $pendingSellers }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Revenue</span>
                    <span class="fw-600" style="color:#43c6ac;">RM {{ number_format($totalRevenue, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
