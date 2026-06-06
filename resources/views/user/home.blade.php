@extends('layouts.app')
@section('title', 'Home')
@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge mb-3 px-3 py-2" style="background:rgba(255,255,255,0.2);color:#fff;border-radius:20px;font-size:0.85rem;">🎉 Free delivery above RM 100</span>
                <h1>Your Stationery <br><span style="color:#ffc93c;">Paradise</span> Awaits!</h1>
                <p class="mt-3 mb-4">Discover premium pens, notebooks, art supplies and more. Quality stationery for students, artists and professionals.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('shop') }}" class="btn-hero">
                        <i class="bi bi-bag me-2"></i>Shop Now
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light rounded-pill px-4 py-3">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div style="font-size:10rem;filter:drop-shadow(0 20px 40px rgba(0,0,0,0.2));">✏️</div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="stat-bar">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3 stat-item">
                <div class="number">500+</div>
                <div class="label">Products</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="number">2,000+</div>
                <div class="label">Happy Customers</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="number">50+</div>
                <div class="label">Trusted Sellers</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="number">4.9★</div>
                <div class="label">Average Rating</div>
            </div>
        </div>
    </div>
</div>

<!-- Categories -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Shop by <span>Category</span></h2>
        </div>
        <div class="d-flex gap-3 flex-wrap justify-content-center">
            <a href="{{ route('shop') }}" class="category-pill text-decoration-none">🛍️ All Products</a>
            @foreach($categories as $cat)
                <a href="{{ route('shop', ['category' => $cat->id]) }}" class="category-pill text-decoration-none">
                    {{ $cat->icon }} {{ $cat->name }}
                    <span class="badge rounded-pill ms-1" style="background:rgba(108,99,255,0.15);color:#6c63ff;font-size:0.7rem;">{{ $cat->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="pb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Featured <span>Products</span></h2>
            <a href="{{ route('shop') }}" class="btn" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:10px 24px;font-weight:600;">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
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
                            <h6 class="fw-600 mb-1">
                                <a href="{{ route('product.detail', $product->slug) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                            </h6>
                            <p class="text-muted small mb-2" style="flex:1;">{{ Str::limit($product->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="price">RM {{ number_format($product->price, 2) }}</span>
                                <span class="text-muted small">
                                    @if($product->stock > 10) <span class="text-success">✓ In Stock</span>
                                    @elseif($product->stock > 0) <span class="text-warning">⚠ Low Stock</span>
                                    @else <span class="text-danger">✗ Out</span>
                                    @endif
                                </span>
                            </div>
                            @auth
                                @if(auth()->user()->role === 'user')
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-cart btn">
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
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
                    <p class="text-muted">No products yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why PenBox -->
<section class="py-5" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-white fw-700">Why Choose <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">PenBox?</span></h2>
        </div>
        <div class="row g-4 text-center text-white">
            <div class="col-md-3">
                <div class="fs-1 mb-3">🚚</div>
                <h5 class="fw-700">Fast Delivery</h5>
                <p class="text-white-50 small">Same-day dispatch for orders before 3PM</p>
            </div>
            <div class="col-md-3">
                <div class="fs-1 mb-3">✅</div>
                <h5 class="fw-700">Quality Guaranteed</h5>
                <p class="text-white-50 small">Only authentic, premium stationery brands</p>
            </div>
            <div class="col-md-3">
                <div class="fs-1 mb-3">💳</div>
                <h5 class="fw-700">Secure Payment</h5>
                <p class="text-white-50 small">Pay via QR bank transfer with receipt verification</p>
            </div>
            <div class="col-md-3">
                <div class="fs-1 mb-3">🎁</div>
                <h5 class="fw-700">Gift Wrapping</h5>
                <p class="text-white-50 small">Beautiful gift wrapping available on request</p>
            </div>
        </div>
    </div>
</section>

@endsection
