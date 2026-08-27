@extends('layouts.app')

@section('title', 'Daily Groceries in Rajshahi City | Rajshahi Bazaar (রাজশাহী বাজার)')
@section('meta_description', 'Order fresh daily groceries in Rajshahi city. Fresh vegetables, rice, lentils, oil, fish & meat delivered to your doorstep in 45-60 mins. Pay with bKash, Nagad or Cash on Delivery.')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-tag">
                    <span>⚡ Rajshahi City Express Delivery (45–60 Mins)</span>
                </div>
                <h1 class="hero-title">
                    Daily Groceries in <br>
                    <span class="highlight">Rajshahi City</span>
                </h1>
                <p class="hero-desc">
                    Get farm-fresh vegetables, Padma river fish, Nazirshail & Miniket rice, pure mustard oil, fresh milk, and all daily household essentials delivered straight to your home.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('items') }}" class="btn btn-primary" id="btn-hero-items">
                        🥦 Browse Grocery Items
                    </a>
                    <a href="{{ route('order') }}" class="btn btn-accent" id="btn-hero-order">
                        🛍️ Order Now & Pay (bKash/COD)
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-icon">⏱️</div>
                        <div class="stat-info">
                            <h4>45-60 Mins</h4>
                            <p>Fast City Delivery</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🥬</div>
                        <div class="stat-info">
                            <h4>100% Fresh</h4>
                            <p>Direct from Farmers</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📱</div>
                        <div class="stat-info">
                            <h4>bKash / COD</h4>
                            <p>Safe BD Payments</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card-banner">
                    <span class="banner-badge">🔥 TODAY'S RAJSHAHI SPECIAL</span>
                    <h3 class="banner-title">Fresh Padma River Fish & Farm Vegetables</h3>
                    <p class="banner-text">
                        Hand-picked daily morning harvest delivered clean, weighed, and hygienic directly to your kitchen.
                    </p>

                    <div class="floating-order-box">
                        <div class="delivery-slot-preview">
                            <div>
                                <strong style="display: block; font-size: 0.95rem; color: #0f172a;">📍 Next Delivery Window</strong>
                                <span style="font-size: 0.8rem; color: #64748b;">Shaheb Bazar • Kazla • Motihar • Upashahar</span>
                            </div>
                            <span class="delivery-pill">⚡ 60 Mins</span>
                        </div>
                        <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <span style="font-weight: 700; color: #059669; font-size: 1.1rem;">Min. Order: ৳200</span>
                            <a href="{{ route('items') }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.82rem;">Start Shopping ➔</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rajshahi Delivery Zones Strip -->
<section class="zones-section">
    <div class="container">
        <div class="zones-container">
            <span class="zones-title">📍 We Deliver All Across Rajshahi:</span>
            <a href="{{ route('items') }}" class="zone-tag">Shaheb Bazar</a>
            <a href="{{ route('items') }}" class="zone-tag">Rajshahi University (RU)</a>
            <a href="{{ route('items') }}" class="zone-tag">Motihar</a>
            <a href="{{ route('items') }}" class="zone-tag">Kazla</a>
            <a href="{{ route('items') }}" class="zone-tag">Talaimari</a>
            <a href="{{ route('items') }}" class="zone-tag">Upashahar</a>
            <a href="{{ route('items') }}" class="zone-tag">Laxmipur</a>
            <a href="{{ route('items') }}" class="zone-tag">Rani Bazar</a>
            <a href="{{ route('items') }}" class="zone-tag">Sagarpara</a>
            <a href="{{ route('items') }}" class="zone-tag">Bornali</a>
            <a href="{{ route('items') }}" class="zone-tag">Alupatti</a>
            <a href="{{ route('items') }}" class="zone-tag">Zero Point</a>
        </div>
    </div>
</section>

<!-- Featured Grocery Categories -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <h2>Popular Grocery Categories</h2>
                <p>Browse fresh essentials across authentic Bangladeshi grocery departments</p>
            </div>
            <a href="{{ route('items') }}" class="section-link">View All Items (Page 2) ➔</a>
        </div>

        <div class="category-grid">
            <a href="{{ route('items', ['category' => 'Vegetables']) }}" class="category-card">
                <div class="category-icon">🥦</div>
                <div class="category-name">Fresh Vegetables</div>
                <span class="category-count">সবজি • 18 Items</span>
            </a>

            <a href="{{ route('items', ['category' => 'Rice & Grains']) }}" class="category-card">
                <div class="category-icon">🌾</div>
                <div class="category-name">Rice & Lentils</div>
                <span class="category-count">চাল ও ডাল • 12 Items</span>
            </a>

            <a href="{{ route('items', ['category' => 'Cooking Oil']) }}" class="category-card">
                <div class="category-icon">🫒</div>
                <div class="category-name">Cooking Oil & Ghee</div>
                <span class="category-count">তেল ও ঘি • 8 Items</span>
            </a>

            <a href="{{ route('items', ['category' => 'Spices']) }}" class="category-card">
                <div class="category-icon">🌶️</div>
                <div class="category-name">Spices & Masala</div>
                <span class="category-count">মসলা • 14 Items</span>
            </a>

            <a href="{{ route('items', ['category' => 'Fish & Meat']) }}" class="category-card">
                <div class="category-icon">🐟</div>
                <div class="category-name">Fish & Meat</div>
                <span class="category-count">মাছ ও মাংস • 10 Items</span>
            </a>

            <a href="{{ route('items', ['category' => 'Dairy & Eggs']) }}" class="category-card">
                <div class="category-icon">🥛</div>
                <div class="category-name">Dairy, Milk & Eggs</div>
                <span class="category-count">দুধ ও ডিম • 9 Items</span>
            </a>
        </div>
    </div>
</section>

<!-- Today's Daily Deals Preview -->
<section class="section" style="background: #ffffff; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <h2>Today's Fresh Deals in Rajshahi</h2>
                <p>Special discounted prices on daily essential groceries in BDT (৳)</p>
            </div>
            <a href="{{ route('items') }}" class="section-link">See Full Grocery Catalog ➔</a>
        </div>

        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card" 
                 data-product-id="deal-1" 
                 data-product-name="Fresh Red Tomato (টমেটো)" 
                 data-product-bengali="দেশি লাল টমেটো" 
                 data-product-price="60" 
                 data-product-unit="1 kg" 
                 data-product-image="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&q=80">
                <span class="product-badge-discount">-20% OFF</span>
                <div class="product-img-wrap">
                    <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&q=80" alt="Fresh Red Tomato">
                </div>
                <div class="product-details">
                    <span class="product-category-tag">Vegetables</span>
                    <h3 class="product-title">Fresh Deshi Tomato (টমেটো)</h3>
                    <span class="product-unit">Unit: 1 kg • Farm Fresh</span>
                    <div class="product-price-row">
                        <span class="current-price">৳60</span>
                        <span class="old-price">৳75</span>
                    </div>
                    <div class="product-card-actions">
                        <button type="button" class="btn-add-cart">
                            <span>🛒 Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card" 
                 data-product-id="deal-2" 
                 data-product-name="Miniket Premium Rice (মিনিকেট চাল)" 
                 data-product-bengali="প্রিমিয়াম মিনিকেট চাল" 
                 data-product-price="78" 
                 data-product-unit="1 kg" 
                 data-product-image="https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&q=80">
                <span class="product-badge-discount">Best Seller</span>
                <div class="product-img-wrap">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&q=80" alt="Miniket Rice">
                </div>
                <div class="product-details">
                    <span class="product-category-tag">Rice & Grains</span>
                    <h3 class="product-title">Miniket Premium Rice (মিনিকেট চাল)</h3>
                    <span class="product-unit">Unit: 1 kg • Polished & Clean</span>
                    <div class="product-price-row">
                        <span class="current-price">৳78</span>
                        <span class="old-price">৳85</span>
                    </div>
                    <div class="product-card-actions">
                        <button type="button" class="btn-add-cart">
                            <span>🛒 Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card" 
                 data-product-id="deal-3" 
                 data-product-name="Rupchanda Fortified Soybean Oil (সয়াবিন তেল)" 
                 data-product-bengali="রূপচাঁদা সয়াবিন তেল ১ লিটার" 
                 data-product-price="185" 
                 data-product-unit="1 Litre" 
                 data-product-image="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&q=80">
                <span class="product-badge-discount">-৳10 OFF</span>
                <div class="product-img-wrap">
                    <img src="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&q=80" alt="Rupchanda Soybean Oil">
                </div>
                <div class="product-details">
                    <span class="product-category-tag">Cooking Oil</span>
                    <h3 class="product-title">Rupchanda Soybean Oil (সয়াবিন তেল)</h3>
                    <span class="product-unit">Unit: 1 Litre Bottle</span>
                    <div class="product-price-row">
                        <span class="current-price">৳185</span>
                        <span class="old-price">৳195</span>
                    </div>
                    <div class="product-card-actions">
                        <button type="button" class="btn-add-cart">
                            <span>🛒 Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card" 
                 data-product-id="deal-4" 
                 data-product-name="Farm Fresh Brown Eggs (ফার্মের লাল ডিম)" 
                 data-product-bengali="ফার্মের তাজা ডিম" 
                 data-product-price="145" 
                 data-product-unit="1 Dozen (12 pcs)" 
                 data-product-image="https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=400&q=80">
                <span class="product-badge-discount">Fresh Stock</span>
                <div class="product-img-wrap">
                    <img src="https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=400&q=80" alt="Farm Fresh Eggs">
                </div>
                <div class="product-details">
                    <span class="product-category-tag">Dairy & Eggs</span>
                    <h3 class="product-title">Farm Fresh Brown Eggs (ডিম)</h3>
                    <span class="product-unit">Unit: 1 Dozen (12 pcs)</span>
                    <div class="product-price-row">
                        <span class="current-price">৳145</span>
                        <span class="old-price">৳155</span>
                    </div>
                    <div class="product-card-actions">
                        <button type="button" class="btn-add-cart">
                            <span>🛒 Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us in Rajshahi -->
<section class="section">
    <div class="container">
        <div class="section-header" style="justify-content: center; text-align: center;">
            <div class="section-title-wrap">
                <h2>Why Rajshahi Residents Choose Us</h2>
                <p>Reliable, superfast, and 100% fresh grocery delivery designed for Rajshahi city families</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-lg">🥬</div>
                <h3>100% Farm Fresh</h3>
                <p>Directly procured each morning from Rajshahi district farmers and local agricultural markets.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon-lg">🚀</div>
                <h3>60-Minute Delivery</h3>
                <p>Our localized delivery hubs ensure quick delivery to your home in Shaheb Bazar, Kazla, Motihar, and beyond.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon-lg">💳</div>
                <h3>bKash, Nagad & COD</h3>
                <p>Multiple convenient payment methods. Pay digitally through bKash / Nagad or pay Cash on Delivery.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon-lg">🔄</div>
                <h3>Instant Replacement</h3>
                <p>Not satisfied with the quality of any fruit, vegetable, or fish? Get an immediate free replacement at your door.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials from Rajshahi -->
<section class="section" style="background: #f1f5f9;">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <h2>What Our Customers in Rajshahi Say</h2>
                <p>Trusted daily by hundreds of households, university faculty, and students</p>
            </div>
        </div>

        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div>
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Living near Rajshahi University campus, getting fresh morning vegetables used to take an hour in traffic. Rajshahi Bazaar delivers crisp vegetables and fresh milk right to my door in 45 minutes!"
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">TN</div>
                    <div class="author-info">
                        <h4>Dr. Tariqul N.</h4>
                        <p>Professor, RU Motihar Campus</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div>
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "The payment via bKash is very smooth, and their fish is genuinely fresh Padma river quality. Best online grocery platform for families in Upashahar and Shaheb Bazar."
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">SB</div>
                    <div class="author-info">
                        <h4>Sadia Begum</h4>
                        <p>Resident, Housing Upashahar</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div>
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Clean packaging and exact weights. I order Nazirshail rice, Rupchanda oil, and fresh eggs every week. Highly recommended for everyone in Rajshahi city!"
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">AH</div>
                    <div class="author-info">
                        <h4>Abul Hossain</h4>
                        <p>Business Owner, Shaheb Bazar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bottom CTA Banner -->
<section class="section" style="padding-top: 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #047857 0%, #065f46 100%); border-radius: var(--radius-lg); padding: 45px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 25px; box-shadow: var(--shadow-lg);">
            <div>
                <h3 style="font-size: 1.9rem; font-weight: 800; margin-bottom: 8px;">Ready to Stock Your Kitchen Today?</h3>
                <p style="font-size: 1.05rem; opacity: 0.9;">Explore over 50+ fresh Bangladeshi grocery essentials or place a quick order right now.</p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('items') }}" class="btn" style="background: #ffffff; color: #047857; font-weight: 800;">Browse All Groceries ➔</a>
                <a href="{{ route('order') }}" class="btn btn-accent">Order with bKash/COD ➔</a>
            </div>
        </div>
    </div>
</section>
@endsection
