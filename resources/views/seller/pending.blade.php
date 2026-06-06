@extends('layouts.app')
@section('title', 'Account Pending')
@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg,#667eea,#764ba2,#f093fb);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card border-0 shadow-lg p-5" style="border-radius:24px;">
                    <div style="font-size:5rem;">⏳</div>
                    <h3 class="fw-700 mt-3">Account Under Review</h3>
                    <p class="text-muted">Hi <strong>{{ auth()->user()->name }}</strong>! Your seller account is pending admin approval.</p>
                    <div class="p-4 rounded-3 text-start mb-4" style="background:#f8f7ff;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:35px;height:35px;background:#43c6ac;flex-shrink:0;"><i class="bi bi-check"></i></div>
                            <span class="small">Account registered</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:35px;height:35px;background:#ffc93c;flex-shrink:0;"><i class="bi bi-clock"></i></div>
                            <span class="small fw-600">Admin review (in progress)</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;background:#e0e0e0;flex-shrink:0;"><i class="bi bi-shop"></i></div>
                            <span class="small text-muted">Start selling</span>
                        </div>
                    </div>
                    <p class="text-muted small">This usually takes 1–2 business days. You'll be redirected once approved.</p>
                    <div class="d-flex gap-2 justify-content-center mt-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">Browse Shop</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn rounded-pill px-4" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
