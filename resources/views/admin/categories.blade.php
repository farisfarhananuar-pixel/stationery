@extends('layouts.dashboard')
@section('title', 'Categories')
@section('page-title', 'Manage Categories')
@section('content')

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card-custom card">
            <div class="card-header"><i class="bi bi-plus-circle me-2"></i>Add Category</div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Art Supplies" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-600 small">Emoji Icon</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g. 🎨" value="{{ old('icon') }}">
                        <div class="form-text text-muted">Pick an emoji that represents this category.</div>
                    </div>
                    <button type="submit" class="btn btn-grad w-100">
                        <i class="bi bi-plus-circle me-2"></i>Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card-custom card">
            <div class="card-header"><i class="bi bi-tags me-2"></i>All Categories</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td class="fs-4">{{ $cat->icon ?? '📦' }}</td>
                                    <td class="fw-600">{{ $cat->name }}</td>
                                    <td><code class="small">{{ $cat->slug }}</code></td>
                                    <td><span class="badge bg-light text-dark">{{ $cat->products_count }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.categories.delete', $cat) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                    onclick="return confirm('Delete {{ $cat->name }}? Products in this category will be uncategorised.')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No categories yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
