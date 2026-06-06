@extends('layouts.dashboard')
@section('title', 'Manage Sellers')
@section('page-title', 'Manage Sellers')
@section('content')

<div class="card-custom card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-shop me-2"></i>All Sellers</span>
        <span class="badge bg-white text-dark">{{ $sellers->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Seller</th>
                        <th>Shop Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                                         style="width:38px;height:38px;background:linear-gradient(135deg,#6c63ff,#ff6584);flex-shrink:0;font-size:0.85rem;">
                                        {{ strtoupper(substr($seller->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-600 small">{{ $seller->name }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $seller->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-600">{{ $seller->sellerProfile->shop_name ?? '—' }}</td>
                            <td class="text-muted small">{{ $seller->email }}</td>
                            <td>
                                @php $status = $seller->sellerProfile->status ?? 'pending'; @endphp
                                @if($status === 'approved')
                                    <span class="badge badge-approved">✓ Approved</span>
                                @elseif($status === 'pending')
                                    <span class="badge badge-pending">⏳ Pending</span>
                                @else
                                    <span class="badge badge-rejected">✗ Rejected</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $seller->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($status === 'pending')
                                        <form method="POST" action="{{ route('admin.sellers.approve', $seller) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-grad" onclick="return confirm('Approve this seller?')">
                                                <i class="bi bi-check"></i> Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.sellers.reject', $seller) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Reject this seller?')">
                                                <i class="bi bi-x"></i> Reject
                                            </button>
                                        </form>
                                    @elseif($status === 'approved')
                                        <form method="POST" action="{{ route('admin.sellers.reject', $seller) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-warning rounded-pill">
                                                <i class="bi bi-pause"></i> Revoke
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.sellers.approve', $seller) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success rounded-pill">
                                                <i class="bi bi-arrow-clockwise"></i> Re-approve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No sellers registered yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $sellers->links('pagination::bootstrap-5') }}</div>
@endsection
