@extends('layouts.dashboard')
@section('title', 'All Orders')
@section('page-title', 'All Orders')
@section('content')

<div class="card-custom card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-receipt me-2"></i>All Orders</span>
        <span class="badge bg-white text-dark">{{ $orders->total() }} Total</span>
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
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><span class="fw-600" style="color:#6c63ff;">{{ $order->order_number }}</span></td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->seller->sellerProfile->shop_name ?? $order->seller->name }}</td>
                            <td class="fw-600">RM {{ number_format($order->total_amount, 2) }}</td>
                            <td>{!! $order->paymentStatusBadge() !!}</td>
                            <td>{!! $order->deliveryStatusBadge() !!}</td>
                            <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">No orders yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
@endsection
