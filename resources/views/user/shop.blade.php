@extends('layouts.app')
@section('title', 'Shop')
@section('content')

<div style="background:linear-gradient(135deg,#6c63ff,#ff6584);padding:40px 0;" class="mb-4">
    <div class="container">
        <h2 class="text-white fw-800 mb-1">🛍️ Our Products</h2>
        <p class="text-white-50 mb-0">Discover premium stationery for every need</p>
    </div>
</div>

<div class="container pb-5">
    <!-- Search & Filter Bar -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('shop') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-600 small">Search Products</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search pens, notebooks..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-600 small">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-600 small">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn flex-fill" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:12px;font-weight:600;">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search','category','sort']))
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary" style="border-radius:12px;">✕</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Results Count -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">Showing <strong>{{ $products->total() }}</strong> products</p>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card card h-100">
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <img src="{{ $product->image && !str_starts_with($product->image, 'http') ? asset('storage/'.$product->image) : ($product->image ?? 'https://placehold.co/400x400/e8e8ff/6c63ff?text='.urlencode($product->name)) }}"
                             class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
                    </a>
                    <div class="card-body d-flex flex-column p-3">
                        @if($product->category)
                            <span class="badge-category mb-2 d-inline-block">{{ $product->category->icon }} {{ $product->category->name }}</span>
                        @endif
                        <h6 class="fw-600 mb-1" style="font-size:0.9rem;">
                            <a href="{{ route('product.detail', $product->slug) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                        </h6>
                        <p class="text-muted mb-2" style="font-size:0.8rem;flex:1;">{{ Str::limit($product->description, 70) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="price">RM {{ number_format($product->price, 2) }}</span>
                            <small class="text-muted">Stock: {{ $product->stock }}</small>
                        </div>
                        @auth
                            @if(auth()->user()->role === 'user')
                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-cart btn" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus me-1"></i>
                                        {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('product.detail', $product->slug) }}" class="btn-add-cart btn">View Details</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-add-cart btn">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div style="font-size:4rem;">🔍</div>
                <h5 class="text-muted mt-3">No products found</h5>
                <p class="text-muted">Try adjusting your search or filters</p>
                <a href="{{ route('shop') }}" class="btn" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:10px 28px;">View All Products</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
