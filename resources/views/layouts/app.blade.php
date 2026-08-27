<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Daily Groceries in Rajshahi City | Rajshahi Bazaar')</title>
    <meta name="description" content="@yield('meta_description', 'Fresh farm groceries, organic vegetables, daily fish, meat & pantry essentials delivered in Rajshahi city within 60 minutes. Easy bKash, Nagad & Cash on delivery.')">
    
    <!-- App Stylesheet -->
    <link rel="stylesheet" href="/css/app.css">
    
    <!-- Open Graph / Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Daily Groceries in Rajshahi City">
    <meta property="og:description" content="Superfast online grocery shopping in Rajshahi city. Order fresh food with bKash and COD.">
    
    @yield('styles')
</head>
<body>
    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <div class="container">
            <div>
                <span class="top-bar-badge">RAJSHAHI EXPRESS</span>
                <span>⚡ Superfast 60-Minute Grocery Delivery across Rajshahi City | Free Delivery on orders over ৳500!</span>
            </div>
            <div class="top-bar-contact">
                <span>📍 Shaheb Bazar, Rajshahi</span>
                <span>📞 Hotline: <a href="tel:+8801712345678" style="font-weight: 700; color: #fff;">+880 1712-345678</a></span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="container nav-container">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-logo" id="nav-brand-logo">
                <div class="brand-logo-icon">🌿</div>
                <div class="brand-logo-text">
                    Rajshahi Bazaar
                    <span>রাজশাহী ডেইলি বাজার</span>
                </div>
            </a>

            <!-- Search Form -->
            <form action="{{ route('items') }}" method="GET" class="nav-search" id="nav-search-form">
                <input type="text" name="search" placeholder="Search vegetables, miniket rice, soybean oil..." value="{{ request('search') }}">
                <button type="submit" class="nav-search-btn" aria-label="Search">🔍</button>
            </form>

            <!-- Navigation Links (All 4 Connected Pages) -->
            <ul class="nav-links">
                <li>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" id="nav-link-home">
                        🏠 Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}" class="nav-link {{ request()->routeIs('items') ? 'active' : '' }}" id="nav-link-items">
                        🥦 Grocery Items
                    </a>
                </li>
                <li>
                    <a href="{{ route('order') }}" class="nav-link {{ request()->routeIs('order') ? 'active' : '' }}" id="nav-link-order">
                        🛍️ Order Now
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" id="nav-link-contact">
                        📞 Contact Us
                    </a>
                </li>
            </ul>

            <!-- Header Actions -->
            <div class="nav-actions">
                <a href="{{ route('order') }}" class="cart-trigger-btn" id="nav-cart-btn">
                    <span>🛒 Cart</span>
                    <span class="cart-badge">0</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: Brand -->
                <div>
                    <div class="footer-logo">
                        <span>🌿</span> Rajshahi Bazaar
                    </div>
                    <p class="footer-desc">
                        Rajshahi's most trusted online grocery service. We deliver farm-fresh vegetables, Padma river fish, fresh meat, and pantry essentials directly to your doorstep in 45-60 minutes.
                    </p>
                    <div class="payment-pills">
                        <span class="pay-pill bkash">bKash</span>
                        <span class="pay-pill nagad">Nagad</span>
                        <span class="pay-pill rocket">Rocket</span>
                        <span class="pay-pill upay">Upay</span>
                        <span class="pay-pill cod">Cash on Delivery</span>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h4 class="footer-heading">Website Pages</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">🏠 1. Home Page</a></li>
                        <li><a href="{{ route('items') }}">🥦 2. Grocery Items</a></li>
                        <li><a href="{{ route('order') }}">🛍️ 3. Order Now</a></li>
                        <li><a href="{{ route('contact') }}">📞 4. Contact Us</a></li>
                    </ul>
                </div>

                <!-- Column 3: Coverage Areas -->
                <div>
                    <h4 class="footer-heading">Rajshahi Coverage</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('items') }}">Shaheb Bazar & Zero Point</a></li>
                        <li><a href="{{ route('items') }}">Kazla & RU Campus</a></li>
                        <li><a href="{{ route('items') }}">Talaimari & Motihar</a></li>
                        <li><a href="{{ route('items') }}">Upashahar & Laxmipur</a></li>
                        <li><a href="{{ route('items') }}">Rani Bazar & Bornali</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact Info -->
                <div>
                    <h4 class="footer-heading">Hub Office</h4>
                    <ul class="footer-links">
                        <li style="color: #cbd5e1;">📍 Holding #45, Station Road, Shaheb Bazar, Rajshahi-6000</li>
                        <li style="color: #cbd5e1;">📞 Hotline: +880 1712-345678</li>
                        <li style="color: #cbd5e1;">💬 WhatsApp: +880 1812-987654</li>
                        <li style="color: #cbd5e1;">✉️ support@rajshahibazaar.com</li>
                        <li style="color: #34d399; font-weight: 700; margin-top: 6px;">⏰ 7:00 AM – 10:00 PM (Daily)</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="footer-bottom">
                <p>© {{ date('Y') }} Rajshahi Bazaar (রাজশাহী বাজার). All rights reserved. Connecting fresh local farmers to Rajshahi households.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Script -->
    <script src="/js/cart.js"></script>
    @yield('scripts')
</body>
</html>
