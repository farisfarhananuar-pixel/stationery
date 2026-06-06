@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #43c6ac 0%, #667eea 50%, #f093fb 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="text-center mb-4">
                    <h1 class="text-white fw-800 fs-2">✏️ PenBox</h1>
                    <p class="text-white-50">Create your account and start shopping!</p>
                </div>
                <div class="card border-0 shadow-lg" style="border-radius:24px;">
                    <div class="card-body p-5">
                        <h4 class="fw-700 mb-1">Create Account</h4>
                        <p class="text-muted small mb-4">Fill in the details below to register</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-600 small">I want to register as:</label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="role" id="role_user" value="user" {{ old('role','user')==='user'?'checked':'' }}>
                                        <label class="btn w-100 py-3 border-2" for="role_user" style="border-radius:15px;">
                                            <i class="bi bi-person-circle fs-3 d-block mb-1 text-primary"></i>
                                            <strong>Customer</strong><br><small class="text-muted">Browse & buy</small>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="role" id="role_seller" value="seller" {{ old('role')==='seller'?'checked':'' }}>
                                        <label class="btn w-100 py-3 border-2" for="role_seller" style="border-radius:15px;">
                                            <i class="bi bi-shop fs-3 d-block mb-1 text-warning"></i>
                                            <strong>Seller</strong><br><small class="text-muted">Sell products</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Full Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ahmad Farid" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="you@email.com" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="012-3456789" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small">Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Your address" value="{{ old('address') }}">
                                </div>
                            </div>

                            <!-- Seller-only fields -->
                            <div id="seller-fields" style="display:none;" class="mt-3 p-4 rounded-3" style="background:#f8f7ff;">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge" style="background:linear-gradient(135deg,#6c63ff,#ff6584);font-size:0.8rem;">Seller Info</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-600 small">Shop Name *</label>
                                    <input type="text" name="shop_name" class="form-control" placeholder="My Awesome Shop" value="{{ old('shop_name') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-600 small">Shop Description</label>
                                    <textarea name="shop_description" class="form-control" rows="2" placeholder="Tell customers about your shop...">{{ old('shop_description') }}</textarea>
                                </div>
                                <div class="alert alert-warning border-0 py-2 px-3 mt-2" style="background:#fff8e1;border-radius:10px;">
                                    <i class="bi bi-info-circle me-2"></i><small>Your seller account will need admin approval before you can start selling.</small>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 mt-4" style="background:linear-gradient(135deg,#6c63ff,#ff6584);border:none;color:#fff;border-radius:50px;padding:12px;font-weight:600;">
                                Create Account <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <p class="text-muted small">Already have an account? <a href="{{ route('login') }}" style="color:#6c63ff;font-weight:600;">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input[name="role"]').forEach(r => {
        r.addEventListener('change', function() {
            document.getElementById('seller-fields').style.display = this.value === 'seller' ? 'block' : 'none';
        });
    });
    // Init
    if (document.querySelector('input[name="role"]:checked').value === 'seller') {
        document.getElementById('seller-fields').style.display = 'block';
    }
</script>
@endpush
@endsection
