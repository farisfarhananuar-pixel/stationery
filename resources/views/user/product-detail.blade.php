@extends('layouts.app')
@section('title', $product->name)
@section('content')

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color:#6c63ff;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none" style="color:#6c63ff;">Shop</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:20px;">
                <img src="{{ $product->image && !str_starts_with($product->image, 'http') ? asset('storage/'.$product->image) : ($product->image ?? 'https://placehold.co/600x500/e8e8ff/6c63ff?text='.urlencode($product->name)) }}"
                     class="img-fluid" alt="{{ $product->name }}" style="height:400px;object-fit:cover;width:100%;">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            @if($product->category)
                <span class="badge mb-3" style="background:linear-gradient(135deg,#6c63ff,#ff6584);font-size:0.85rem;border-radius:20px;padding:6px 14px;">
                    {{ $product->category->icon }} {{ $product->category->name }}
                </span>
            @endif
            <h1 class="fw-700 mb-3" style="font-size:1.8rem;">{{ $product->name }}</h1>

            <!-- Seller Info -->
            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#f8f7ff;">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700" style="width:45px;height:45px;background:linear-gradient(135deg,#6c63ff,#ff6584);flex-shrink:0;">
                    {{ strtoupper(substr($product->seller->sellerProfile->shop_name ?? $product->seller->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-600 small">{{ $product->seller->sellerProfile->shop_name ?? $product->seller->name }}</div>
                    <div class="text-muted" style="font-size:0.75rem;"><i class="bi bi-shop me-1"></i>Verified Seller</div>
                </div>
            </div>

            <!-- Price & Stock -->
            <div class="d-flex align-items-center gap-4 mb-4">
                <div>
                    <span style="font-size:2.2rem;font-weight:800;background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                        RM {{ number_format($product->price, 2) }}
                    </span>
                </div>
                <div>
                    @if($product->stock > 10)
                        <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->stock }})</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bi bi-exclamation-circle me-1"></i>Low Stock ({{ $product->stock }} left)</span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h5 class="fw-700 mb-2">Description</h5>
                <p class="text-muted" style="line-height:1.8;">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart -->
            @auth
                @if(auth()->user()->role === 'user' && $product->stock > 0)
                    <form method="POST" action="{{ route('cart.add') }}" class="d-flex gap-3 align-items-end">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <label class="form-label fw-600 small">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" style="width:100px;border-radius:12px;">
                        </div>
                        <button type="submit" class="btn flex-fill" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:12px 28px;font-weight:700;font-size:1rem;">
                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                        </button>
                    </form>
                @elseif($product->stock <= 0)
                    <button disabled class="btn w-100" style="background:#ccc;color:#fff;border-radius:50px;padding:14px;font-weight:700;">Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn w-100" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:14px;font-weight:700;">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to Purchase
                </a>
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count() > 0)
        <hr class="my-5">
        <h3 class="fw-700 mb-4">Related Products</h3>
        <div class="row g-4">
            @foreach($related as $p)
                <div class="col-6 col-md-3">
                    <div class="product-card card h-100">
                        <a href="{{ route('product.detail', $p->slug) }}">
                            <img src="{{ $p->image && !str_starts_with($p->image, 'http') ? asset('storage/'.$p->image) : ($p->image ?? 'https://placehold.co/400x300/e8e8ff/6c63ff?text='.urlencode($p->name)) }}"
                                 class="card-img-top" alt="{{ $p->name }}" style="height:160px;object-fit:cover;">
                        </a>
                        <div class="card-body p-3">
                            <h6 class="fw-600 mb-1" style="font-size:0.85rem;">{{ $p->name }}</h6>
                            <div class="price" style="font-size:1rem;">RM {{ number_format($p->price, 2) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
