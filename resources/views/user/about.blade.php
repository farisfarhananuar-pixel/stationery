@extends('layouts.app')
@section('title', 'About Us')
@section('content')

<!-- Hero -->
<div style="background:linear-gradient(135deg,#6c63ff,#ff6584,#43c6ac);padding:70px 0;" class="text-center text-white">
    <h1 class="fw-800 mb-3" style="font-size:2.8rem;">About <span style="color:#ffc93c;">PenBox</span></h1>
    <p class="fs-5" style="opacity:0.85;">Your trusted stationery partner since 2022</p>
</div>

<div class="container py-5">

    <!-- Our Story -->
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
            <span class="badge mb-3 px-3 py-2" style="background:linear-gradient(135deg,#6c63ff,#ff6584);font-size:0.85rem;border-radius:20px;">Our Story</span>
            <h2 class="fw-700 mb-3" style="font-size:2rem;">From Passion to <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Purpose</span></h2>
            <p class="text-muted" style="line-height:1.9;">PenBox started as a small university project born out of a simple frustration: finding quality stationery in Malaysia was either too expensive or too inconvenient. We set out to change that.</p>
            <p class="text-muted" style="line-height:1.9;">Today, PenBox is a vibrant online marketplace connecting passionate stationery sellers with students, artists, professionals and collectors across the country. We believe that the right pen, notebook or art supply can spark creativity and change lives.</p>
            <p class="text-muted" style="line-height:1.9;">Our platform supports local sellers while giving buyers access to a curated selection of premium stationery — all in one place.</p>
        </div>
        <div class="col-lg-6">
            <div class="p-5 text-center rounded-4" style="background:linear-gradient(135deg,#f8f7ff,#fff);">
                <div style="font-size:7rem;">✏️📓🎨</div>
                <p class="text-muted mt-3 fw-500">Pens · Notebooks · Art Supplies · Office Essentials</p>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 h-100 p-4" style="border-radius:20px;background:linear-gradient(135deg,#6c63ff,#a18dff);color:#fff;">
                <div class="fs-1 mb-3">🎯</div>
                <h4 class="fw-700">Our Mission</h4>
                <p style="opacity:0.9;line-height:1.8;">To make quality stationery accessible, affordable, and enjoyable for every Malaysian — from school students to professional artists and corporate offices.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 h-100 p-4" style="border-radius:20px;background:linear-gradient(135deg,#ff6584,#ff9eb5);color:#fff;">
                <div class="fs-1 mb-3">🔭</div>
                <h4 class="fw-700">Our Vision</h4>
                <p style="opacity:0.9;line-height:1.8;">To become Malaysia's most loved stationery marketplace, empowering local sellers and inspiring creativity in every corner of the country.</p>
            </div>
        </div>
    </div>

    <!-- Our Goods & Services — 10 items with descriptions -->
    <div class="text-center mb-4">
        <h2 class="fw-700">Our <span style="background:linear-gradient(135deg,#6c63ff,#ff6584);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Goods & Services</span></h2>
        <p class="text-muted">Everything a stationery lover could ever need</p>
    </div>

    <div class="row g-4 mb-5">
        @php
        $goods = [
            ['icon'=>'✏️','name'=>'Pens & Pencils','desc'=>'From everyday ballpoints to premium gel pens and artist-grade pencils. We stock Pilot, Stabilo, Faber-Castell, Pentel and more for all writing needs.','color'=>'#6c63ff'],
            ['icon'=>'📓','name'=>'Notebooks & Journals','desc'=>'Dotted, lined, blank and grid notebooks in A4, A5, and B5 formats. Premium brands like Leuchtturm1917, Muji, Kokuyo and Moleskine always in stock.','color'=>'#ff6584'],
            ['icon'=>'🎨','name'=>'Art Supplies','desc'=>'Watercolours, acrylic paints, fineliners, markers and sketch pads for budding artists and seasoned professionals. Sakura, Winsor & Newton, and more.','color'=>'#43c6ac'],
            ['icon'=>'📐','name'=>'Drawing & Drafting Tools','desc'=>'Technical pens, rulers, set squares, compasses and drafting tools for engineering, architecture and design students.','color'=>'#ffc93c'],
            ['icon'=>'📎','name'=>'Office Supplies','desc'=>'Staplers, paper clips, binders, correction tape, sticky notes, scissors and every desk essential you need to stay organised and productive.','color'=>'#667eea'],
            ['icon'=>'🎒','name'=>'Pencil Cases & Bags','desc'=>'Stylish and functional pencil cases, stationery pouches and school bags from brands like Smiggle, Kipling and homegrown Malaysian designers.','color'=>'#f093fb'],
            ['icon'=>'🖌️','name'=>'Calligraphy & Lettering','desc'=>'Brush pens, dip nibs, calligraphy ink and practice sheets for hobbyists and professionals who love the art of beautiful writing.','color'=>'#4facfe'],
            ['icon'=>'📌','name'=>'Planner & Organiser Tools','desc'=>'Monthly, weekly, and daily planners, habit trackers, sticker sets and washi tape to help you stay on top of your goals in style.','color'=>'#fa709a'],
            ['icon'=>'🖨️','name'=>'Paper & Cardstock','desc'=>'High-quality printing paper, cardstock, coloured paper and specialty craft paper for scrapbooking, card-making and printing projects.','color'=>'#a18cd1'],
            ['icon'=>'🔖','name'=>'Stickers & Decoratives','desc'=>'Cute and aesthetic sticker sets, washi tape collections, stamps and decorative items to personalise your journals and planners.','color'=>'#f5576c'],
            ['icon'=>'💼','name'=>'Bulk & Wholesale Orders','desc'=>'Special pricing for schools, colleges, corporations and event organisers needing bulk stationery supplies. Contact us for a custom quote.','color'=>'#30cfd0'],
            ['icon'=>'🚚','name'=>'Fast Delivery Service','desc'=>'Same-day dispatch for orders placed before 3PM. Nationwide delivery via Pos Laju and J&T Express. Free shipping on orders above RM100.','color'=>'#43c6ac'],
        ];
        @endphp

        @foreach($goods as $g)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 h-100 shadow-sm p-4 text-center" style="border-radius:20px;transition:all 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="mb-3" style="font-size:2.5rem;">{{ $g['icon'] }}</div>
                    <h6 class="fw-700 mb-2">{{ $g['name'] }}</h6>
                    <p class="text-muted small mb-0" style="line-height:1.7;">{{ $g['desc'] }}</p>
                    <div class="mt-3 mx-auto" style="width:40px;height:4px;border-radius:4px;background:{{ $g['color'] }};"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Values -->
    <div class="p-5 rounded-4 text-center" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
        <h3 class="text-white fw-700 mb-4">What We Stand For</h3>
        <div class="row g-4">
            @foreach([['🌟','Quality First','We curate only the best — no compromise on quality for our customers.'],['🤝','Seller Empowerment','We help local sellers grow their businesses through our trusted platform.'],['💚','Community','We are more than a shop — we are a community of stationery enthusiasts.'],['🔒','Trust & Safety','Verified sellers, secure payments, and reliable delivery — always.']] as $v)
                <div class="col-md-3">
                    <div style="font-size:2.5rem;">{{ $v[0] }}</div>
                    <h6 class="text-white fw-700 mt-2">{{ $v[1] }}</h6>
                    <p class="text-white-50 small">{{ $v[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
