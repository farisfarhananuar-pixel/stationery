@extends('layouts.dashboard')
@section('title', 'Manage Users')
@section('page-title', 'Manage Users')
@section('content')

<div class="card-custom card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>All Customers</span>
        <span class="badge bg-white text-dark">{{ $users->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                                         style="width:38px;height:38px;background:linear-gradient(135deg,#43c6ac,#667eea);flex-shrink:0;font-size:0.85rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-600 small">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td class="text-muted small">{{ $user->phone ?? '—' }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-approved">Active</span>
                                @else
                                    <span class="badge badge-rejected">Suspended</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm rounded-pill {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                            onclick="return confirm('{{ $user->is_active ? 'Suspend' : 'Activate' }} this user?')">
                                        <i class="bi bi-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                        {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No customers registered yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $users->links('pagination::bootstrap-5') }}</div>
@endsection
