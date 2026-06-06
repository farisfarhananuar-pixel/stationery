<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PenBox') – Your Stationery Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c63ff;
            --secondary: #ff6584;
            --accent: #43c6ac;
            --warning-custom: #ffc93c;
            --dark: #1a1a2e;
            --light-bg: #f8f7ff;
        }
        * { font-family: 'Poppins', sans-serif; }
        body { background: var(--light-bg); }

        /* Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, #6c63ff 0%, #ff6584 50%, #43c6ac 100%);
            box-shadow: 0 4px 20px rgba(108,99,255,0.3);
            padding: 12px 0;
        }
        .navbar-custom .navbar-brand {
            font-size: 1.6rem; font-weight: 800; color: #fff !important;
            letter-spacing: -0.5px;
        }
        .navbar-custom .nav-link { color: rgba(255,255,255,0.9) !important; font-weight: 500; }
        .navbar-custom .nav-link:hover { color: #fff !important; transform: translateY(-1px); }
        .navbar-custom .btn-cart {
            background: rgba(255,255,255,0.25); border: 2px solid rgba(255,255,255,0.6);
            color: #fff; border-radius: 25px; padding: 6px 18px; font-weight: 600;
            transition: all 0.3s;
        }
        .navbar-custom .btn-cart:hover { background: #fff; color: var(--primary); }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 30%, #f093fb 60%, #f5576c 100%);
            min-height: 520px; display: flex; align-items: center;
            position: relative; overflow: hidden;
        }
        .hero-section::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }
        .hero-section h1 { font-size: 3.2rem; font-weight: 800; color: #fff; line-height: 1.2; }
        .hero-section p { color: rgba(255,255,255,0.85); font-size: 1.1rem; }
        .btn-hero {
            background: #fff; color: var(--primary); border: none;
            padding: 14px 36px; border-radius: 50px; font-weight: 700;
            font-size: 1rem; box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .btn-hero:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(0,0,0,0.25); color: var(--primary); }

        /* Product Cards */
        .product-card {
            border: none; border-radius: 20px; overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s; background: #fff;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(108,99,255,0.2);
        }
        .product-card .card-img-top {
            height: 220px; object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .product-card .badge-category {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff; border-radius: 20px; font-size: 0.75rem; padding: 4px 12px;
        }
        .product-card .price {
            font-size: 1.3rem; font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .btn-add-cart {
            background: linear-gradient(135deg, #6c63ff, #ff6584);
            border: none; color: #fff; border-radius: 50px;
            padding: 8px 20px; font-weight: 600; width: 100%;
            transition: all 0.3s;
        }
        .btn-add-cart:hover { opacity: 0.85; transform: scale(1.02); color: #fff; }

        /* Section Titles */
        .section-title { font-size: 2rem; font-weight: 700; color: var(--dark); }
        .section-title span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* Category Pills */
        .category-pill {
            background: #fff; border: 2px solid #e8e8ff;
            border-radius: 50px; padding: 10px 24px;
            font-weight: 500; color: var(--dark);
            transition: all 0.3s; cursor: pointer; display: inline-block;
        }
        .category-pill:hover, .category-pill.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff; border-color: transparent;
            transform: translateY(-2px);
        }

        /* Stats bar */
        .stat-bar { background: linear-gradient(135deg, #1a1a2e, #16213e); color: #fff; padding: 14px 0; }
        .stat-item { text-align: center; }
        .stat-item .number { font-size: 1.6rem; font-weight: 700; color: var(--warning-custom); }
        .stat-item .label { font-size: 0.8rem; color: rgba(255,255,255,0.7); }

        /* Sidebar Dashboards */
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh; padding: 20px 0;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7) !important; padding: 12px 24px;
            border-radius: 0 25px 25px 0; margin: 2px 12px 2px 0;
            font-weight: 500; transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(108,99,255,0.4), rgba(255,101,132,0.4));
            color: #fff !important;
        }
        .sidebar .nav-link i { width: 22px; }
        .sidebar-brand {
            padding: 20px 24px; font-size: 1.3rem; font-weight: 800;
            background: linear-gradient(135deg, #6c63ff, #ff6584);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* Cards Dashboard */
        .stat-card {
            border: none; border-radius: 20px; padding: 24px;
            color: #fff; position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: ''; position: absolute; right: -20px; top: -20px;
            width: 100px; height: 100px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .stat-card-1 { background: linear-gradient(135deg, #6c63ff, #a18dff); }
        .stat-card-2 { background: linear-gradient(135deg, #ff6584, #ff9eb5); }
        .stat-card-3 { background: linear-gradient(135deg, #43c6ac, #76e8cf); }
        .stat-card-4 { background: linear-gradient(135deg, #ffc93c, #ffe083); }
        .stat-card .stat-number { font-size: 2rem; font-weight: 800; }
        .stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; }
        .stat-card .stat-icon { font-size: 2.5rem; opacity: 0.25; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); }

        /* Tables */
        .table-custom { border-radius: 15px; overflow: hidden; }
        .table-custom thead { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; }
        .table-custom tbody tr:hover { background: #f8f7ff; }

        /* Badges */
        .badge-pending { background: #ffc93c; color: #000; }
        .badge-approved { background: #43c6ac; color: #fff; }
        .badge-rejected { background: #ff6584; color: #fff; }
        .badge-shipped { background: #6c63ff; color: #fff; }
        .badge-delivered { background: #28a745; color: #fff; }

        /* Forms */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.15);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none; color: #fff; border-radius: 50px;
            padding: 12px 32px; font-weight: 600; transition: all 0.3s;
        }
        .btn-primary-custom:hover { opacity: 0.85; transform: translateY(-2px); color: #fff; }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: rgba(255,255,255,0.8); padding: 50px 0 20px;
        }
        footer h5 { color: #fff; font-weight: 700; }
        footer a { color: rgba(255,255,255,0.6); text-decoration: none; }
        footer a:hover { color: var(--warning-custom); }

        /* Alerts */
        .alert { border: none; border-radius: 15px; }
        .alert-success { background: #d4f5ed; color: #1a8a6e; }
        .alert-danger { background: #ffe0e7; color: #c0392b; }

        /* Cart badge */
        .cart-badge {
            position: absolute; top: -6px; right: -8px;
            background: var(--secondary); color: #fff;
            width: 20px; height: 20px; border-radius: 50%;
            font-size: 0.7rem; display: flex; align-items: center; justify-content: center;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                ✏️ PenBox
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-4 text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('website.owner') }}">Our Team</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'user')
                            <a href="{{ route('cart') }}" class="btn btn-cart position-relative me-2">
                                <i class="bi bi-cart3"></i> Cart
                                @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('user.orders') }}" class="btn btn-cart">
                                <i class="bi bi-bag-check"></i> Orders
                            </a>
                        @elseif(auth()->user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-cart">
                                <i class="bi bi-shop"></i> Seller Panel
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-cart">
                                <i class="bi bi-gear"></i> Admin Panel
                            </a>
                        @endif
                        <div class="dropdown">
                            <button class="btn btn-cart dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="px-3 py-2">
                                    <small class="text-muted">Logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong></small>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-cart">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-cart">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mx-4 mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible mx-4 mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>✏️ PenBox</h5>
                    <p class="text-white-50">Your one-stop stationery paradise. Quality pens, notebooks, art supplies & more — delivered to your doorstep.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Customer Care</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @auth <li><a href="{{ route('user.orders') }}">My Orders</a></li> @endauth
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact Info</h5>
                    <p class="text-white-50 small">
                        <i class="bi bi-geo-alt me-2"></i>No. 12, Jalan Utama, 50480 Kuala Lumpur<br>
                        <i class="bi bi-telephone me-2"></i>+60 12-345 6789<br>
                        <i class="bi bi-envelope me-2"></i>hello@penbox.com
                    </p>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <div class="text-center text-white-50 small">
                © {{ date('Y') }} PenBox Stationery. All rights reserved. Made with ❤️ for stationery lovers.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
