@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')

<!-- Hero -->
<div style="background:linear-gradient(135deg,#43c6ac,#667eea,#f093fb);padding:60px 0;" class="text-center text-white">
    <h1 class="fw-800 mb-2" style="font-size:2.5rem;">📬 Contact Us</h1>
    <p class="fs-5" style="opacity:0.85;">We'd love to hear from you. Get in touch!</p>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Info -->
        <div class="col-lg-5">
            <h3 class="fw-700 mb-4">Get In Touch</h3>

            <div class="d-flex flex-column gap-4">
                <!-- Address -->
                <div class="d-flex gap-4 align-items-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                         style="width:55px;height:55px;background:linear-gradient(135deg,#6c63ff,#a18dff);font-size:1.3rem;">
                        📍
                    </div>
                    <div>
                        <h6 class="fw-700 mb-1">Our Address</h6>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            PenBox Stationery Sdn. Bhd.<br>
                            No. 12, Jalan Utama 3/5,<br>
                            Taman Industri Utama,<br>
                            50480 Kuala Lumpur,<br>
                            Wilayah Persekutuan, Malaysia.
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="d-flex gap-4 align-items-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                         style="width:55px;height:55px;background:linear-gradient(135deg,#ff6584,#ff9eb5);font-size:1.3rem;">
                        📞
                    </div>
                    <div>
                        <h6 class="fw-700 mb-1">Phone Number</h6>
                        <p class="text-muted mb-0">
                            Main: <a href="tel:+60123456789" class="text-decoration-none" style="color:#6c63ff;">+60 12-345 6789</a><br>
                            WhatsApp: <a href="https://wa.me/60123456789" class="text-decoration-none" style="color:#43c6ac;">+60 12-345 6789</a><br>
                            Office: <a href="tel:+60312345678" class="text-decoration-none" style="color:#6c63ff;">+60 3-1234 5678</a>
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="d-flex gap-4 align-items-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                         style="width:55px;height:55px;background:linear-gradient(135deg,#43c6ac,#667eea);font-size:1.3rem;">
                        ✉️
                    </div>
                    <div>
                        <h6 class="fw-700 mb-1">Email Address</h6>
                        <p class="text-muted mb-0">
                            General: <a href="mailto:hello@penbox.com" class="text-decoration-none" style="color:#6c63ff;">hello@penbox.com</a><br>
                            Support: <a href="mailto:support@penbox.com" class="text-decoration-none" style="color:#6c63ff;">support@penbox.com</a><br>
                            Wholesale: <a href="mailto:wholesale@penbox.com" class="text-decoration-none" style="color:#6c63ff;">wholesale@penbox.com</a>
                        </p>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="d-flex gap-4 align-items-start">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                         style="width:55px;height:55px;background:linear-gradient(135deg,#ffc93c,#ffe083);font-size:1.3rem;">
                        🕐
                    </div>
                    <div>
                        <h6 class="fw-700 mb-1">Business Hours</h6>
                        <p class="text-muted mb-0" style="line-height:1.8;">
                            Mon – Fri: 9:00 AM – 6:00 PM<br>
                            Saturday: 9:00 AM – 2:00 PM<br>
                            Sunday & Public Holiday: Closed
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mt-5">
                <h6 class="fw-700 mb-3">Follow Us</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none"
                       style="width:45px;height:45px;background:linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045);">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none"
                       style="width:45px;height:45px;background:#1877f2;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none"
                       style="width:45px;height:45px;background:#000;">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    <a href="https://wa.me/60123456789" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none"
                       style="width:45px;height:45px;background:#25d366;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Form + Map -->
        <div class="col-lg-7">
            <!-- Contact Form -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-4">Send Us a Message</h5>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Email</label>
                                <input type="email" class="form-control" placeholder="your@email.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small">Subject</label>
                                <select class="form-select">
                                    <option>General Enquiry</option>
                                    <option>Order Issue</option>
                                    <option>Seller Enquiry</option>
                                    <option>Wholesale / Bulk Order</option>
                                    <option>Feedback</option>
                                    <option>Others</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small">Message</label>
                                <textarea class="form-control" rows="4" placeholder="How can we help you?"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn" style="background:linear-gradient(135deg,#6c63ff,#ff6584);color:#fff;border-radius:50px;padding:12px 32px;font-weight:600;"
                                        onclick="alert('Thank you! We will get back to you within 1-2 business days.')">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Map -->
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:20px;">
                <div class="card-header text-white fw-600" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
                    <i class="bi bi-map me-2"></i>Find Us on the Map
                </div>
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.752844553!2d101.6869!3d3.1478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49c701efeae7%3A0xf4d98e5b2f1c0c1!2sKuala%20Lumpur%20City%20Centre%2C%20Kuala%20Lumpur%2C%20Federal%20Territory%20of%20Kuala%20Lumpur!5e0!3m2!1sen!2smy!4v1683000000000!5m2!1sen!2smy"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="card-body p-3 bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill" style="color:#6c63ff;"></i>
                        <small class="text-muted">No. 12, Jalan Utama 3/5, 50480 Kuala Lumpur — Near Dang Wangi LRT Station</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
