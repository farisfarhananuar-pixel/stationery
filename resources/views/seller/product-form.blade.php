@extends('layouts.dashboard')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add New Product')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom card">
            <div class="card-header">
                <i class="bi bi-{{ isset($product) ? 'pencil' : 'plus-circle' }} me-2"></i>
                {{ isset($product) ? 'Edit Product' : 'Add New Product' }}
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                    </div>
                @endif

                <form method="POST"
                      action="{{ isset($product) ? route('seller.products.update', $product) : route('seller.products.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method('PUT') @endif

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-600 small">Product Name *</label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="e.g. Pilot G2 Gel Pen Black" required
                                   value="{{ old('name', $product->name ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Price (RM) *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">RM</span>
                                <input type="number" name="price" class="form-control"
                                       step="0.01" min="0" placeholder="0.00" required
                                       value="{{ old('price', $product->price ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Stock Quantity *</label>
                            <input type="number" name="stock" class="form-control"
                                   min="0" placeholder="0" required
                                   value="{{ old('stock', $product->stock ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                                       style="width:3rem;height:1.5rem;">
                                <label class="form-check-label fw-600 ms-2" for="is_active">Active (visible in shop)</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-600 small">Description *</label>
                            <textarea name="description" class="form-control" rows="4"
                                      placeholder="Describe your product in detail..." required>{{ old('description', $product->description ?? '') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-600 small">Product Image</label>
                            @if(isset($product) && $product->image)
                                <div class="mb-3">
                                    <img src="{{ !str_starts_with($product->image,'http') ? asset('storage/'.$product->image) : $product->image }}"
                                         style="height:100px;width:100px;object-fit:cover;border-radius:12px;"
                                         alt="Current image">
                                    <span class="text-muted small ms-2">Current image</span>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text text-muted">Max 5MB. JPG, PNG, WEBP accepted.</div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-grad px-4">
                            <i class="bi bi-{{ isset($product) ? 'save' : 'plus-circle' }} me-2"></i>
                            {{ isset($product) ? 'Save Changes' : 'Add Product' }}
                        </button>
                        <a href="{{ route('seller.products') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
