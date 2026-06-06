@extends('layouts.dashboard')
@section('title', 'Shop Profile')
@section('page-title', 'Shop Profile & Payment Setup')
@section('content')

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-custom card">
            <div class="card-header"><i class="bi bi-shop me-2"></i>Shop Information</div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-600 small">Shop Name *</label>
                            <input type="text" name="shop_name" class="form-control"
                                   value="{{ old('shop_name', $seller->sellerProfile->shop_name ?? '') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-600 small">Shop Description</label>
                            <textarea name="shop_description" class="form-control" rows="3"
                                      placeholder="Tell customers about your shop...">{{ old('shop_description', $seller->sellerProfile->shop_description ?? '') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control"
                                   placeholder="e.g. Maybank, CIMB, RHB"
                                   value="{{ old('bank_name', $seller->sellerProfile->bank_name ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Bank Account Number</label>
                            <input type="text" name="bank_account" class="form-control"
                                   placeholder="e.g. 1234567890"
                                   value="{{ old('bank_account', $seller->sellerProfile->bank_account ?? '') }}">
                        </div>

                        <!-- QR Code Upload -->
                        <div class="col-12">
                            <label class="form-label fw-600 small">Payment QR Code</label>
                            @if($seller->sellerProfile->qr_code_image ?? false)
                                <div class="mb-3 text-center p-4 rounded-3" style="background:#f8f7ff;">
                                    <img src="{{ asset('storage/'.$seller->sellerProfile->qr_code_image) }}"
                                         style="max-width:180px;border-radius:15px;box-shadow:0 8px 20px rgba(0,0,0,0.1);" alt="QR Code">
                                    <div class="text-success small mt-2 fw-600"><i class="bi bi-check-circle me-1"></i>QR Code uploaded</div>
                                </div>
                            @else
                                <div class="mb-2 p-3 rounded-3" style="background:#fff8e1;">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                                    <small>No QR code uploaded yet. Customers won't be able to see your payment QR.</small>
                                </div>
                            @endif
                            <input type="file" name="qr_code_image" class="form-control" accept="image/*">
                            <div class="form-text text-muted">Upload your DuitNow / bank QR code image. Max 5MB.</div>
                        </div>

                        <!-- Shop Logo -->
                        <div class="col-12">
                            <label class="form-label fw-600 small">Shop Logo</label>
                            @if($seller->sellerProfile->shop_logo ?? false)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$seller->sellerProfile->shop_logo) }}"
                                         style="height:70px;width:70px;object-fit:cover;border-radius:50%;border:3px solid #e8e8ff;" alt="Logo">
                                </div>
                            @endif
                            <input type="file" name="shop_logo" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-grad mt-4 px-4">
                        <i class="bi bi-save me-2"></i>Save Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Preview & Status -->
    <div class="col-lg-5">
        <div class="card-custom card mb-4">
            <div class="card-header"><i class="bi bi-patch-check me-2"></i>Account Status</div>
            <div class="card-body p-4 text-center">
                @php $status = $seller->sellerProfile->status ?? 'pending'; @endphp
                @if($status === 'approved')
                    <div style="font-size:3.5rem;">✅</div>
                    <h5 class="fw-700 mt-2 text-success">Account Approved</h5>
                    <p class="text-muted small">Your shop is live and visible to customers.</p>
                @elseif($status === 'pending')
                    <div style="font-size:3.5rem;">⏳</div>
                    <h5 class="fw-700 mt-2" style="color:#ffc93c;">Pending Approval</h5>
                    <p class="text-muted small">Admin is reviewing your seller account. This usually takes 1–2 business days.</p>
                @else
                    <div style="font-size:3.5rem;">❌</div>
                    <h5 class="fw-700 mt-2 text-danger">Account Rejected</h5>
                    <p class="text-muted small">Contact admin for more information.</p>
                @endif
            </div>
        </div>

        <div class="card-custom card">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Payment Setup Guide</div>
            <div class="card-body p-4">
                <ol class="text-muted small" style="padding-left:1.2rem;line-height:2.2;">
                    <li>Enter your <strong>bank name</strong> and <strong>account number</strong></li>
                    <li>Upload your <strong>DuitNow/bank QR code</strong> image</li>
                    <li>Customers will scan your QR to pay for orders</li>
                    <li>They upload their receipt as proof</li>
                    <li>You approve or reject based on receipt verification</li>
                </ol>
                <div class="mt-3 p-3 rounded-3" style="background:#f0fff8;">
                    <small class="text-muted"><i class="bi bi-lightbulb me-1 text-warning"></i>
                    Tip: Make sure your QR code is clear and scannable. Save it as PNG for best quality.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
