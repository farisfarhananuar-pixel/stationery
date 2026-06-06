@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 40%, #f093fb 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h1 class="text-white fw-800 fs-2">✏️ PenBox</h1>
                    <p class="text-white-50">Welcome back! Login to continue.</p>
                </div>
                <div class="card border-0 shadow-lg" style="border-radius:24px;">
                    <div class="card-body p-5">
                        <h4 class="fw-700 mb-1">Sign In</h4>
                        <p class="text-muted small mb-4">Enter your credentials below</p>

                        @if($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-600 small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="you@email.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-600 small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100" style="background:linear-gradient(135deg,#6c63ff,#ff6584);border:none;color:#fff;border-radius:50px;padding:12px;font-weight:600;">
                                Login <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted small">Don't have an account? <a href="{{ route('register') }}" style="color:#6c63ff;font-weight:600;">Register here</a></p>
                        </div>

                        <hr class="my-3">
                        <div class="text-center">
                            <p class="text-muted" style="font-size:0.75rem;">Demo Accounts:</p>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <span class="badge bg-light text-dark border small">admin@penbox.com</span>
                                <span class="badge bg-light text-dark border small">seller@penbox.com</span>
                                <span class="badge bg-light text-dark border small">user@penbox.com</span>
                            </div>
                            <p class="text-muted mt-1" style="font-size:0.75rem;">All passwords: <strong>password</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
