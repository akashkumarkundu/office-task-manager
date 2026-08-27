@extends('layouts.app')

@section('title', 'Contact Us & Rajshahi Customer Care | Rajshahi Bazaar (রাজশাহী বাজার)')
@section('meta_description', 'Contact Rajshahi Bazaar customer support. Reach our Shaheb Bazar hub office via hotline +880 1712-345678, WhatsApp, or send an instant message.')

@section('styles')
<style>
    .contact-hero-header {
        background: linear-gradient(135deg, #065f46 0%, #047857 50%, #0f172a 100%);
        color: white;
        padding: 50px 0 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    .contact-hero-header::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(52, 211, 153, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .contact-hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }
    .contact-hero-desc {
        font-size: 1.1rem;
        color: #cbd5e1;
        max-width: 680px;
    }

    .contact-main-grid {
        display: grid;
        grid-template-columns: 1fr 1.25fr;
        gap: 35px;
        align-items: start;
        margin-bottom: 60px;
    }

    /* Premium Modern Form Card */
    .premium-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 38px;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }
    .premium-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #059669 0%, #10b981 50%, #f97316 100%);
    }

    .form-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #047857;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        margin-bottom: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .form-card-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 28px;
    }

    /* Hub Info Card */
    .hub-info-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 35px;
        box-shadow: var(--shadow-md);
        margin-bottom: 25px;
    }
    .hub-header-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .channel-row {
        display: flex;
        gap: 16px;
        margin-bottom: 22px;
        align-items: flex-start;
    }
    .channel-icon-box {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        background: #ecfdf5;
        color: #047857;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.12);
    }
    .channel-text-wrap h4 {
        font-size: 0.98rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 3px;
    }
    .channel-text-wrap p, .channel-text-wrap a {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.4;
    }
    .channel-text-wrap a:hover {
        color: #059669;
    }

    .quick-cta-bar {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }
    .quick-cta-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
        transition: var(--transition);
    }
    .quick-cta-btn.whatsapp {
        background: #25d366;
        color: white;
    }
    .quick-cta-btn.whatsapp:hover {
        background: #1eb956;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }
    .quick-cta-btn.call {
        background: #059669;
        color: white;
    }
    .quick-cta-btn.call:hover {
        background: #047857;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    /* FAQ Section */
    .faq-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 40px;
        margin-bottom: 60px;
        box-shadow: var(--shadow-sm);
    }
    .faq-item-block {
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 0;
    }
    .faq-item-block:last-child {
        border-bottom: none;
    }
    .faq-q-title {
        font-size: 1.08rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .faq-a-body {
        font-size: 0.95rem;
        color: #475569;
        line-height: 1.6;
        padding-left: 28px;
    }

    @media (max-width: 900px) {
        .contact-main-grid {
            grid-template-columns: 1fr;
        }
        .premium-form-card {
            padding: 24px;
        }
    }
</style>
@endsection

@section('content')
<!-- Contact Hero Header -->
<div class="contact-hero-header">
    <div class="container">
        <span class="badge" style="background: rgba(255,255,255,0.18); color: #34d399; margin-bottom: 12px;">PAGE 4 • CONTACT US</span>
        <h1 class="contact-hero-title">Contact & Customer Care in Rajshahi</h1>
        <p class="contact-hero-desc">
            Have a question about daily grocery delivery, fresh farm sourcing, bulk order placement, or payments in Rajshahi city? We're active and ready to assist you.
        </p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; padding: 20px 26px; border-radius: var(--radius-md); font-weight: 700; margin-bottom: 35px; display: flex; align-items: center; gap: 14px; box-shadow: var(--shadow-sm);">
            <span style="font-size: 1.8rem;">🎉</span>
            <div>
                <strong style="display: block; font-size: 1.05rem; margin-bottom: 2px;">বার্তাটি সফলভাবে পাঠানো হয়েছে! (Message Sent Successfully)</strong>
                <span style="font-size: 0.92rem; opacity: 0.95;">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="contact-main-grid">
        <!-- Left: Hub Info & Direct Channels -->
        <div>
            <div class="hub-info-card">
                <h3 class="hub-header-title">
                    <span>📍</span> Rajshahi City Central Hub
                </h3>

                <div class="channel-row">
                    <div class="channel-icon-box">🏢</div>
                    <div class="channel-text-wrap">
                        <h4>Hub & Warehouse Office</h4>
                        <p>Holding #45, Station Road, Shaheb Bazar, Rajshahi - 6000, Bangladesh</p>
                        <span style="font-size: 0.78rem; color: #059669; font-weight: 700; display: inline-block; margin-top: 3px;">📍 Heart of Rajshahi Commercial Zone</span>
                    </div>
                </div>

                <div class="channel-row">
                    <div class="channel-icon-box">📞</div>
                    <div class="channel-text-wrap">
                        <h4>Customer Care Hotline</h4>
                        <p><a href="tel:+8801712345678" style="font-weight: 800; color: #047857; font-size: 1.05rem;">+880 1712-345678</a></p>
                        <p style="font-size: 0.82rem; color: #64748b;">Landline: +880 721-123456 (7 AM - 10 PM)</p>
                    </div>
                </div>

                <div class="channel-row">
                    <div class="channel-icon-box" style="background: #ecfdf5; color: #25d366;">💬</div>
                    <div class="channel-text-wrap">
                        <h4>WhatsApp Direct Support</h4>
                        <p><a href="https://wa.me/8801812987654" target="_blank" style="font-weight: 800; color: #25d366;">+880 1812-987654</a></p>
                        <p style="font-size: 0.82rem; color: #64748b;">Instant list ordering & payment confirmation</p>
                    </div>
                </div>

                <div class="channel-row">
                    <div class="channel-icon-box">✉️</div>
                    <div class="channel-text-wrap">
                        <h4>Official Email</h4>
                        <p><a href="mailto:support@rajshahibazaar.com" style="color: #0f172a; font-weight: 600;">support@rajshahibazaar.com</a></p>
                    </div>
                </div>

                <div class="channel-row" style="margin-bottom: 0;">
                    <div class="channel-icon-box">⏰</div>
                    <div class="channel-text-wrap">
                        <h4>Operating & Delivery Hours</h4>
                        <p><strong>7:00 AM – 10:00 PM</strong> (Open All 7 Days a Week)</p>
                    </div>
                </div>

                <div class="quick-cta-bar">
                    <a href="https://wa.me/8801812987654" target="_blank" class="quick-cta-btn whatsapp">
                        💬 WhatsApp Chat
                    </a>
                    <a href="tel:+8801712345678" class="quick-cta-btn call">
                        📞 Call Helpline
                    </a>
                </div>
            </div>

            <!-- Rajshahi Delivery Map Frame -->
            <div class="hub-info-card" style="padding: 22px;">
                <h4 style="font-weight: 800; font-size: 1rem; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; color: #0f172a;">
                    🗺️ Rajshahi City Delivery Perimeter
                </h4>
                <div style="border-radius: var(--radius-md); overflow: hidden; height: 210px; border: 1px solid #e2e8f0; position: relative;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58144.38202996162!2d88.56785194488587!3d24.374514686419728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fbefd0a55ea957%3A0xb366f066b539c878!2sRajshahi%2C%20Bangladesh!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Right: Send Us a Message Form (Redesigned & Elevated) -->
        <div>
            <div class="premium-form-card">
                <span class="form-header-badge">⚡ 30-Min Response Guarantee</span>
                <h2 class="form-card-title">
                    <span>✉️</span> Send Us a Message
                </h2>
                <p class="form-card-subtitle">
                    Fill out the form below and our dedicated Rajshahi customer care team will get back to you promptly.
                </p>

                <form action="{{ route('contact.store') }}" method="POST" id="contact-support-form">
                    @csrf
                    
                    <!-- Row 1: Full Name & Phone -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_name">
                                <span>Your Full Name *</span>
                                <span class="bengali-hint">আপনার নাম</span>
                            </label>
                            <div class="input-with-icon">
                                <span class="input-icon-prefix">👤</span>
                                <input type="text" id="contact_name" name="name" class="form-control" placeholder="e.g., Emon Ahmed" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact_phone">
                                <span>Phone Number *</span>
                                <span class="bengali-hint">মোবাইল নম্বর</span>
                            </label>
                            <div class="input-with-icon">
                                <span class="input-icon-prefix">📱</span>
                                <input type="text" id="contact_phone" name="phone" class="form-control" placeholder="017XXXXXXXX" value="01712345678" required>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Email & Subject -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_email">
                                <span>Email Address</span>
                                <span class="bengali-hint">ঐচ্ছিক</span>
                            </label>
                            <div class="input-with-icon">
                                <span class="input-icon-prefix">✉️</span>
                                <input type="email" id="contact_email" name="email" class="form-control" placeholder="you@example.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact_subject">
                                <span>Inquiry Subject *</span>
                                <span class="bengali-hint">বিষয় নির্বাচন</span>
                            </label>
                            <div class="input-with-icon">
                                <span class="input-icon-prefix">🏷️</span>
                                <select id="contact_subject" name="subject" class="form-control" required>
                                    <option value="Delivery Question">Question about Rajshahi Delivery / Time Slot</option>
                                    <option value="Product Sourcing / Availability">Fresh Item Sourcing / Bulk Order Inquiry</option>
                                    <option value="Payment Inquiry">Payment Assistance (bKash / Nagad / Card)</option>
                                    <option value="Quality Feedback or Replacement">Quality Feedback / Item Replacement Request</option>
                                    <option value="Partnership / Supplier">Become a Local Farm Supplier in Rajshahi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Message Textarea -->
                    <div class="form-group">
                        <label class="form-label" for="contact_message">
                            <span>Your Message *</span>
                            <span class="bengali-hint">আপনার বার্তা লিখুন</span>
                        </label>
                        <div class="input-with-icon" style="align-items: flex-start;">
                            <span class="input-icon-prefix" style="top: 14px;">💬</span>
                            <textarea id="contact_message" name="message" class="form-control" rows="4" placeholder="How can our Rajshahi team assist you with your grocery needs today?" required></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" id="btn-submit-contact" style="width: 100%; padding: 15px; font-size: 1.05rem; margin-top: 10px; box-shadow: var(--shadow-lg);">
                        <span>📤</span> Send Message to Rajshahi Hub
                    </button>

                    <div style="margin-top: 14px; text-align: center; font-size: 0.82rem; color: #64748b;">
                        🔒 Your personal details are strictly protected and never shared.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-card">
        <div style="text-align: center; margin-bottom: 30px;">
            <span class="badge badge-green" style="margin-bottom: 8px;">HELP & KNOWLEDGE</span>
            <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--text-primary);">Frequently Asked Questions</h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">Quick answers about ordering daily groceries across Rajshahi city</p>
        </div>

        @foreach($faqs as $faq)
            <div class="faq-item-block">
                <div class="faq-q-title">
                    <span style="color: #059669; font-size: 1.2rem;">❓</span>
                    <span>{{ $faq['question'] }}</span>
                </div>
                <div class="faq-a-body">
                    {{ $faq['answer'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
