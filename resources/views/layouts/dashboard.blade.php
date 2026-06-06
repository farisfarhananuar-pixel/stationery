<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – PenBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f8f7ff; margin: 0; }
        :root { --primary: #6c63ff; --secondary: #ff6584; --accent: #43c6ac; }

        .sidebar { background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%); min-height: 100vh; width: 260px; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { padding: 24px; font-size: 1.4rem; font-weight: 800; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand span { background: linear-gradient(135deg,#6c63ff,#ff6584); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .sidebar .nav-link { color: rgba(255,255,255,0.65) !important; padding: 12px 24px; border-radius: 0 50px 50px 0; margin: 2px 12px 2px 0; font-weight: 500; transition: all 0.3s; display: flex; align-items: center; gap: 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(108,99,255,0.35); color: #fff !important; }
        .sidebar .nav-section { color: rgba(255,255,255,0.3); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 16px 24px 6px; font-weight: 600; }

        .main-content { margin-left: 260px; min-height: 100vh; }
        .top-bar { background: #fff; border-bottom: 1px solid #eee; padding: 16px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 999; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .top-bar h4 { margin: 0; font-weight: 700; color: #1a1a2e; }
        .content-area { padding: 30px; }

        .stat-card { border: none; border-radius: 20px; padding: 24px; color: #fff; position: relative; overflow: hidden; }
        .stat-card::after { content:''; position:absolute; right:-20px; top:-20px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.1); }
        .stat-card-1 { background: linear-gradient(135deg,#6c63ff,#a18dff); }
        .stat-card-2 { background: linear-gradient(135deg,#ff6584,#ff9eb5); }
        .stat-card-3 { background: linear-gradient(135deg,#43c6ac,#76e8cf); }
        .stat-card-4 { background: linear-gradient(135deg,#ffc93c,#ffe083); color:#333; }
        .stat-card .stat-number { font-size: 2.2rem; font-weight: 800; line-height: 1; }
        .stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; margin-top: 4px; }
        .stat-card .stat-icon { font-size: 3rem; opacity: 0.2; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); }

        .card-custom { border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.06); }
        .card-custom .card-header { background: linear-gradient(135deg,var(--primary),var(--secondary)); color:#fff; border-radius: 20px 20px 0 0 !important; padding: 16px 24px; font-weight: 600; }

        .table thead th { background: linear-gradient(135deg,#6c63ff,#ff6584); color:#fff; border:none; font-weight:600; }
        .table tbody tr:hover { background:#f8f7ff; }

        .btn-grad { background: linear-gradient(135deg,var(--primary),var(--secondary)); border:none; color:#fff; border-radius:50px; padding:8px 22px; font-weight:600; transition:all 0.3s; }
        .btn-grad:hover { opacity:0.85; transform:translateY(-1px); color:#fff; }
        .btn-outline-grad { border:2px solid var(--primary); color:var(--primary); border-radius:50px; padding:7px 20px; font-weight:600; background:transparent; transition:all 0.3s; }
        .btn-outline-grad:hover { background:var(--primary); color:#fff; }

        .form-control:focus,.form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(108,99,255,0.15); }

        .alert { border:none; border-radius:12px; }
        .alert-success { background:#d4f5ed; color:#1a8a6e; }
        .alert-danger { background:#ffe0e7; color:#c0392b; }

        .badge-pending { background:#ffc93c; color:#000; }
        .badge-receipt { background:#6c63ff; color:#fff; }
        .badge-approved { background:#43c6ac; color:#fff; }
        .badge-rejected { background:#ff6584; color:#fff; }
        .badge-processing { background:#ffa500; color:#fff; }
        .badge-shipped { background:#6c63ff; color:#fff; }
        .badge-delivered { background:#28a745; color:#fff; }
        .badge-cancelled { background:#dc3545; color:#fff; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">✏️ <span>PenBox</span></div>
        <div class="pt-3">
            @if(auth()->user()->role === 'seller')
                <div class="nav-section">Main</div>
                <a href="{{ route('seller.dashboard') }}" class="nav-link @if(request()->routeIs('seller.dashboard')) active @endif">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="nav-section">Products</div>
                <a href="{{ route('seller.products') }}" class="nav-link @if(request()->routeIs('seller.products*')) active @endif">
                    <i class="bi bi-box-seam"></i> My Products
                </a>
                <a href="{{ route('seller.products.create') }}" class="nav-link @if(request()->routeIs('seller.products.create')) active @endif">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
                <div class="nav-section">Orders</div>
                <a href="{{ route('seller.orders') }}" class="nav-link @if(request()->routeIs('seller.orders*')) active @endif">
                    <i class="bi bi-bag-check"></i> Orders
                    @php $pending = auth()->user()->sellerOrders()->where('payment_status','receipt_uploaded')->count(); @endphp
                    @if($pending > 0)<span class="badge bg-warning text-dark ms-auto">{{ $pending }}</span>@endif
                </a>
                <div class="nav-section">Account</div>
                <a href="{{ route('seller.profile') }}" class="nav-link @if(request()->routeIs('seller.profile*')) active @endif">
                    <i class="bi bi-shop"></i> Shop Profile
                </a>
            @elseif(auth()->user()->role === 'admin')
                <div class="nav-section">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="nav-section">Management</div>
                <a href="{{ route('admin.users') }}" class="nav-link @if(request()->routeIs('admin.users')) active @endif">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.sellers') }}" class="nav-link @if(request()->routeIs('admin.sellers')) active @endif">
                    <i class="bi bi-shop"></i> Sellers
                    @php $ps = \App\Models\SellerProfile::where('status','pending')->count(); @endphp
                    @if($ps > 0)<span class="badge bg-warning text-dark ms-auto">{{ $ps }}</span>@endif
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link @if(request()->routeIs('admin.orders')) active @endif">
                    <i class="bi bi-receipt"></i> All Orders
                </a>
                <a href="{{ route('admin.categories') }}" class="nav-link @if(request()->routeIs('admin.categories')) active @endif">
                    <i class="bi bi-tags"></i> Categories
                </a>
            @endif
            <div class="nav-section">Site</div>
            <a href="{{ route('home') }}" class="nav-link"><i class="bi bi-house"></i> View Store</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="color:rgba(255,100,100,0.7)!important;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <h4>@yield('page-title', 'Dashboard')</h4>
            <div class="d-flex align-items-center gap-3">
                @if(session('success'))
                    <div class="alert alert-success py-1 px-3 mb-0 small">
                        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger py-1 px-3 mb-0 small">{{ session('error') }}</div>
                @endif
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:38px;height:38px;background:linear-gradient(135deg,#6c63ff,#ff6584)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-600 small">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:0.7rem">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
