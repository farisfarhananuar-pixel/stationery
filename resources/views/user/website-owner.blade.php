@extends('layouts.app')
@section('title', 'Website Owner')
@section('content')

<!-- Hero -->
<div style="background:linear-gradient(135deg,#1a1a2e,#6c63ff,#ff6584);padding:70px 0;" class="text-center text-white">
    <h1 class="fw-800 mb-2" style="font-size:2.5rem;">👨‍💻 Meet The Team</h1>
    <p class="fs-5" style="opacity:0.85;">The passionate developers behind PenBox</p>
</div>

<div class="container py-5">

    <!-- Project Info Banner -->
    <div class="card border-0 shadow-sm mb-5 p-4" style="border-radius:20px;background:linear-gradient(135deg,#f8f7ff,#fff);">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <h5 class="fw-700 mb-1">PenBox – Online Stationery Marketplace</h5>
                <p class="text-muted mb-0 small">A web-based e-commerce system developed as part of a university assignment. Built using <strong>Laravel 10</strong>, <strong>MySQL</strong>, <strong>Bootstrap 5</strong>, and deployed on <strong>Railway</strong>.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge px-3 py-2 me-2" style="background:linear-gradient(135deg,#6c63ff,#ff6584);font-size:0.8rem;border-radius:20px;">Laravel 10</span>
                <span class="badge px-3 py-2 me-2" style="background:#f97316;font-size:0.8rem;border-radius:20px;">Bootstrap 5</span>
                <span class="badge px-3 py-2" style="background:#3b82f6;font-size:0.8rem;border-radius:20px;">MySQL</span>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    @php
    $members = [
        [
            'name' => 'Muhammad Farhan bin Ahmad',
            'matric' => '281234',
            'role' => 'Project Lead & Full-Stack Developer',
            'photo' => 'https://ui-avatars.com/api/?name=Farhan+Ahmad&background=6c63ff&color=fff&size=200&bold=true&font-size=0.4',
            'color' => 'linear-gradient(135deg,#6c63ff,#a18dff)',
            'icon' => '👑',
            'contributions' => [
                'Project architecture and Laravel setup',
                'Database design and migrations',
                'Authentication system (login, register, roles)',
                'User dashboard and shopping cart',
                'Checkout and order placement flow',
                'Receipt upload and payment verification system',
                'Railway deployment and .env configuration',
                'GitHub repository management',
            ]
        ],
        [
            'name' => 'Nur Aisyah binti Zulkifli',
            'matric' => '281235',
            'role' => 'Frontend Developer & UI/UX Designer',
            'photo' => 'https://ui-avatars.com/api/?name=Aisyah+Zulkifli&background=ff6584&color=fff&size=200&bold=true&font-size=0.4',
            'color' => 'linear-gradient(135deg,#ff6584,#ff9eb5)',
            'icon' => '🎨',
            'contributions' => [
                'Overall UI/UX design and colour scheme',
                'Homepage hero section and layout',
                'About Us and Contact Us pages',
                'Responsive design for mobile and tablet',
                'Product cards and shop page styling',
                'Navigation bar and footer design',
                'Website Owner page development',
                'CSS custom styles and animations',
            ]
        ],
        [
            'name' => 'Ahmad Haziq bin Mohd Noor',
            'matric' => '281236',
            'role' => 'Backend Developer & Database Engineer',
            'photo' => 'https://ui-avatars.com/api/?name=Haziq+Noor&background=43c6ac&color=fff&size=200&bold=true&font-size=0.4',
            'color' => 'linear-gradient(135deg,#43c6ac,#76e8cf)',
            'icon' => '⚙️',
            'contributions' => [
                'Seller dashboard and product management',
                'Order management and delivery tracking',
                'Payment approval and rejection logic',
                'Admin panel for user and seller control',
                'Category management system',
                'Database seeding with sample data',
                'Middleware for role-based access control',
                'File upload handling (receipts, QR codes)',
            ]
        ],
        [
            'name' => 'Siti Nabilah binti Rashid',
            'matric' => '281237',
            'role' => 'Tester & Documentation Specialist',
            'photo' => 'https://ui-avatars.com/api/?name=Nabilah+Rashid&background=ffc93c&color=333&size=200&bold=true&font-size=0.4',
            'color' => 'linear-gradient(135deg,#ffc93c,#ffe083)',
            'icon' => '📋',
            'contributions' => [
                'System testing and bug reporting',
                'User acceptance testing (UAT)',
                'Project documentation and report writing',
                'Product data entry and content writing',
                'Product description writing for 12+ items',
                'Presentation slides and demo preparation',
                'Proofreading and quality assurance',
                'User manual preparation',
            ]
        ],
        [
            'name' => 'Mohamad Izzat bin Sulaiman',
            'matric' => '281238',
            'role' => 'System Analyst & Integration Specialist',
            'photo' => 'https://ui-avatars.com/api/?name=Izzat+Sulaiman&background=667eea&color=fff&size=200&bold=true&font-size=0.4',
            'color' => 'linear-gradient(135deg,#667eea,#764ba2)',
            'icon' => '🔗',
            'contributions' => [
                'System analysis and requirements gathering',
                'Use case and data flow diagram creation',
                'Integration of search and filter features',
                'Pagination and query optimisation',
                'Contact Us form and Google Maps embed',
                'Cross-browser compatibility testing',
                'Performance review and code cleanup',
                'GitHub version control and branching strategy',
            ]
        ],
    ];
    @endphp

    <div class="row g-4 mb-5">
        @foreach($members as $i => $m)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius:24px;overflow:hidden;transition:all 0.3s;" onmouseover="this.style.transform='translateY(-8px)';this.style.boxShadow='0 20px 40px rgba(108,99,255,0.18)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
                    <!-- Card Header -->
                    <div class="p-4 text-center text-white" style="background:{{ $m['color'] }};">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $m['photo'] }}"
                                 class="rounded-circle border border-3 border-white"
                                 style="width:90px;height:90px;object-fit:cover;"
                                 alt="{{ $m['name'] }}">
                            <span class="position-absolute bottom-0 end-0 fs-5">{{ $m['icon'] }}</span>
                        </div>
                        <h5 class="fw-700 mt-3 mb-0" style="font-size:1rem;">{{ $m['name'] }}</h5>
                        <div class="opacity-75 small mt-1">Matric No: <strong>{{ $m['matric'] }}</strong></div>
                        <span class="badge mt-2 px-3 py-1" style="background:rgba(255,255,255,0.25);border-radius:20px;font-size:0.75rem;">
                            {{ $m['role'] }}
                        </span>
                    </div>

                    <!-- Contributions -->
                    <div class="card-body p-4">
                        <h6 class="fw-700 mb-3" style="font-size:0.85rem;color:#6c63ff;">
                            <i class="bi bi-check2-square me-1"></i>Contributions
                        </h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($m['contributions'] as $c)
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="bi bi-arrow-right-circle-fill mt-1 flex-shrink-0" style="color:#6c63ff;font-size:0.75rem;"></i>
                                    <span class="text-muted small">{{ $c }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tech Stack -->
    <div class="card border-0 shadow-sm p-5 mb-5" style="border-radius:24px;background:linear-gradient(135deg,#1a1a2e,#16213e);">
        <h4 class="text-white fw-700 text-center mb-4">🛠️ Technology Stack Used</h4>
        <div class="row g-3 text-center">
            @php
            $techs = [
                ['Laravel 10','Backend Framework','#FF2D20','bi-code-slash'],
                ['MySQL','Database','#4479A1','bi-database'],
                ['Bootstrap 5','CSS Framework','#7952B3','bi-bootstrap'],
                ['PHP 8.1','Server Language','#777BB4','bi-filetype-php'],
                ['Railway','Deployment Platform','#0B0D0E','bi-cloud-upload'],
                ['GitHub','Version Control','#181717','bi-github'],
                ['Blade','Templating Engine','#FF2D20','bi-file-code'],
                ['JavaScript','Frontend Logic','#F7DF1E','bi-filetype-js'],
            ];
            @endphp
            @foreach($techs as $t)
                <div class="col-6 col-md-3">
                    <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.06);">
                        <i class="bi {{ $t[3] }} fs-3 text-white mb-2 d-block"></i>
                        <div class="text-white fw-600 small">{{ $t[0] }}</div>
                        <div class="text-white-50" style="font-size:0.72rem;">{{ $t[1] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Acknowledgement -->
    <div class="text-center p-5 rounded-4" style="background:linear-gradient(135deg,#f8f7ff,#fff);border:2px dashed #e8e8ff;">
        <div style="font-size:3rem;">🙏</div>
        <h4 class="fw-700 mt-3 mb-2">Acknowledgement</h4>
        <p class="text-muted" style="max-width:600px;margin:0 auto;line-height:1.8;">
            We would like to express our heartfelt gratitude to our lecturer for the invaluable guidance throughout this project. This system was developed as part of our Web Technology coursework at <strong>Universiti Utara Malaysia (UUM)</strong>. Special thanks to all who provided feedback during testing.
        </p>
        <div class="mt-3 text-muted small">© {{ date('Y') }} PenBox Team — Universiti Utara Malaysia</div>
    </div>
</div>
@endsection
