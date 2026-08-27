@extends('layouts.app')

@section('title', 'Contact Us & Rajshahi Support | Rajshahi Bazaar (রাজশাহী বাজার)')
@section('meta_description', 'Contact Rajshahi Bazaar customer support. Reach our Shaheb Bazar hub office via hotline +880 1712-345678, WhatsApp, or send an instant message.')

@section('styles')
<style>
    .contact-header {
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        color: white;
        padding: 45px 0 35px;
        margin-bottom: 35px;
    }
    .contact-title {
        font-size: 2.3rem;
        font-weight: 800;
        margin-bottom: 8px;
    }
    .contact-desc {
        font-size: 1.05rem;
        opacity: 0.9;
        max-width: 650px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        gap: 35px;
        align-items: start;
        margin-bottom: 60px;
    }

    .info-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 30px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }
    .info-channel-item {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }
    .channel-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .channel-details h4 {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 2px;
    }
    .channel-details p, .channel-details a {
        font-size: 0.95rem;
        color: var(--text-secondary);
    }
    .channel-details a:hover {
        color: var(--primary);
    }

    /* FAQ Accordion */
    .faq-container {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 35px;
        margin-bottom: 60px;
    }
    .faq-item {
        border-bottom: 1px solid var(--border-color);
        padding: 18px 0;
    }
    .faq-item:last-child {
        border-bottom: none;
    }
    .faq-question {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .faq-answer {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin-top: 10px;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="contact-header">
    <div class="container">
        <span class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 12px;">PAGE 4 • CONTACT US</span>
        <h1 class="contact-title">Contact & Customer Support in Rajshahi</h1>
        <p class="contact-desc">
            Have questions about daily grocery delivery, fresh item availability, or payment methods in Rajshahi city? We're here for you 7 days a week.
        </p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 18px 24px; border-radius: var(--radius-md); font-weight: 700; margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 1.5rem;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="contact-grid">
        <!-- Left: Hub Info & Direct Channels -->
        <div>
            <div class="info-card">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px; color: var(--text-primary);">
                    📍 Rajshahi City Main Hub
                </h3>

                <div class="info-channel-item">
                    <div class="channel-icon">🏢</div>
                    <div class="channel-details">
                        <h4>Hub & Warehouse Office</h4>
                        <p>Holding #45, Station Road, Shaheb Bazar, Rajshahi - 6000, Bangladesh</p>
                    </div>
                </div>

                <div class="info-channel-item">
                    <div class="channel-icon">📞</div>
                    <div class="channel-details">
                        <h4>Customer Care Hotline</h4>
                        <p><a href="tel:+8801712345678" style="font-weight: 700; color: #047857;">+880 1712-345678</a></p>
                        <p style="font-size: 0.82rem; color: #64748b;">Landline: +880 721-123456</p>
                    </div>
                </div>

                <div class="info-channel-item">
                    <div class="channel-icon">💬</div>
                    <div class="channel-details">
                        <h4>WhatsApp Direct Support</h4>
                        <p><a href="https://wa.me/8801812987654" target="_blank" style="font-weight: 700; color: #25d366;">+880 1812-987654 (Click to Chat)</a></p>
                    </div>
                </div>

                <div class="info-channel-item">
                    <div class="channel-icon">✉️</div>
                    <div class="channel-details">
                        <h4>Email Assistance</h4>
                        <p><a href="mailto:support@rajshahibazaar.com">support@rajshahibazaar.com</a></p>
                    </div>
                </div>

                <div class="info-channel-item" style="margin-bottom: 0;">
                    <div class="channel-icon">⏰</div>
                    <div class="channel-details">
                        <h4>Operating & Delivery Hours</h4>
                        <p><strong>7:00 AM – 10:00 PM</strong> (Open All 7 Days)</p>
                    </div>
                </div>
            </div>

            <!-- Rajshahi Delivery Map Frame -->
            <div class="info-card" style="padding: 20px;">
                <h4 style="font-weight: 800; font-size: 1rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    🗺️ Rajshahi City Service Perimeter
                </h4>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 200px; border: 1px solid var(--border-color); position: relative;">
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

        <!-- Right: Message Form -->
        <div>
            <div class="info-card">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 8px; color: var(--text-primary);">
                    ✉️ Send Us a Message
                </h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 22px;">
                    Fill out the form below and our Rajshahi support executive will get back to you within 30 minutes.
                </p>

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="contact_name">Your Full Name (আপনার নাম) *</label>
                        <input type="text" id="contact_name" name="name" class="form-control" placeholder="e.g., Emon Ahmed" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_phone">Phone Number (মোবাইল নম্বর) *</label>
                            <input type="text" id="contact_phone" name="phone" class="form-control" placeholder="017XXXXXXXX" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact_email">Email Address (ঐচ্ছিক)</label>
                            <input type="email" id="contact_email" name="email" class="form-control" placeholder="you@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_subject">Inquiry Subject (বিষয়) *</label>
                        <select id="contact_subject" name="subject" class="form-control" required>
                            <option value="Delivery Question">Question about Rajshahi Delivery / Time Slot</option>
                            <option value="Product Sourcing / Availability">Fresh Item Sourcing / Bulk Order Inquiry</option>
                            <option value="Payment Inquiry">Payment Assistance (bKash / Nagad / Card)</option>
                            <option value="Quality Feedback or Replacement">Quality Feedback / Item Replacement Request</option>
                            <option value="Partnership / Supplier">Become a Local Farm Supplier in Rajshahi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_message">Your Message (আপনার বার্তা) *</label>
                        <textarea id="contact_message" name="message" class="form-control" rows="4" placeholder="How can our Rajshahi team assist you today?" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; margin-top: 10px;">
                        📤 Send Message to Rajshahi Hub
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-container">
        <div style="text-align: center; margin-bottom: 30px;">
            <span class="badge badge-green" style="margin-bottom: 8px;">HELP & KNOWLEDGE</span>
            <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary);">Frequently Asked Questions</h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">Quick answers about ordering daily groceries in Rajshahi city</p>
        </div>

        @foreach($faqs as $faq)
            <div class="faq-item">
                <div class="faq-question">
                    <span>❓ {{ $faq['question'] }}</span>
                </div>
                <div class="faq-answer">
                    {{ $faq['answer'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
