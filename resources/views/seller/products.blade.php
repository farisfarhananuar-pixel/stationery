@extends('layouts.dashboard')
@section('title', 'My Products')
@section('page-title', 'My Products')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <span class="text-muted small">{{ $products->total() }} products total</span>
    <a href="{{ route('seller.products.create') }}" class="btn btn-grad">
        <i class="bi bi-plus-circle me-2"></i>Add Product
    </a>
</div>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:18px;overflow:hidden;">
                <div class="position-relative">
                    <img src="{{ $product->image && !str_starts_with($product->image,'http') ? asset('storage/'.$product->image) : ($product->image ?? 'https://placehold.co/300x200/e8e8ff/6c63ff?text=📦') }}"
                         style="width:100%;height:170px;object-fit:cover;" alt="{{ $product->name }}">
                    @if(!$product->is_active)
                        <span class="position-absolute top-0 start-0 m-2 badge bg-danger">Hidden</span>
                    @endif
                    @if($product->stock <= 5)
                        <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">Low Stock</span>
                    @endif
                </div>
                <div class="card-body p-3">
                    @if($product->category)
                        <span class="badge mb-1" style="background:rgba(108,99,255,0.1);color:#6c63ff;font-size:0.72rem;">{{ $product->category->name }}</span>
                    @endif
                    <h6 class="fw-600 mb-1" style="font-size:0.9rem;">{{ $product->name }}</h6>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-700" style="color:#6c63ff;">RM {{ number_format($product->price, 2) }}</span>
                        <span class="text-muted small">Stock: {{ $product->stock }}</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top p-3 d-flex gap-2">
                    <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-grad flex-fill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('seller.products.delete', $product) }}" class="flex-fill">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill w-100"
                                onclick="return confirm('Delete this product?')">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem;">📦</div>
            <h5 class="mt-3 text-muted">No products yet</h5>
            <a href="{{ route('seller.products.create') }}" class="btn btn-grad mt-2">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Product
            </a>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
