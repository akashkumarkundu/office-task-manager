@extends('layouts.app')

@section('title', 'Order Now & Bangladeshi Payment Methods | Rajshahi Bazaar (রাজশাহী বাজার)')
@section('meta_description', 'Place grocery orders with instant Bangladeshi payment methods: bKash, Nagad, Rocket, Upay, Visa or Cash on Delivery (COD) in Rajshahi city.')

@section('styles')
<style>
    .order-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 40px 0 30px;
        margin-bottom: 30px;
    }
    .order-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 6px;
    }
    .order-desc {
        font-size: 1rem;
        color: #94a3b8;
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 30px;
        align-items: start;
        margin-bottom: 60px;
    }

    .checkout-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }
    .card-heading {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 18px;
    }
    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 11px 16px;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 0.95rem;
        color: var(--text-primary);
        transition: var(--transition);
        background: #ffffff;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Payment Methods Grid */
    .payment-methods-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 15px;
    }
    .payment-option {
        position: relative;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .payment-option:hover {
        border-color: #94a3b8;
        transform: translateY(-2px);
    }
    .payment-option.selected {
        border-color: var(--primary);
        background: #f0fdf4;
        box-shadow: 0 4px 12px var(--primary-glow);
    }
    .payment-option input[type="radio"] {
        position: absolute;
        top: 14px;
        right: 14px;
        accent-color: var(--primary);
        width: 18px;
        height: 18px;
    }
    .pay-title-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 4px;
    }
    .pay-badge-pill {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        background: var(--bg-subtle);
        color: var(--text-secondary);
        margin-bottom: 6px;
    }

    /* Cart Items Table in Checkout */
    .cart-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        gap: 12px;
    }
    .cart-item-img {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        background: #f8fafc;
    }
    .cart-qty-ctrl {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        overflow: hidden;
    }
    .cart-qty-btn {
        background: var(--bg-subtle);
        border: none;
        width: 26px;
        height: 26px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-qty-num {
        padding: 0 8px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .order-summary-box {
        background: var(--bg-subtle);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-top: 20px;
    }
    .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        margin-bottom: 10px;
        color: var(--text-secondary);
    }
    .summary-line.grand-total {
        border-top: 2px dashed #cbd5e1;
        padding-top: 14px;
        margin-top: 14px;
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--primary-dark);
    }

    /* Modal Simulation */
    .pay-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(6px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .pay-modal-box {
        background: white;
        border-radius: var(--radius-lg);
        width: 100%;
        max-width: 440px;
        padding: 30px;
        box-shadow: var(--shadow-xl);
        position: relative;
        animation: scaleIn 0.25s ease-out;
    }
    @keyframes scaleIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 900px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
        .payment-methods-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="order-header">
    <div class="container">
        <span class="badge" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 10px;">PAGE 3 • ORDER NOW</span>
        <h1 class="order-title">Place Order & Bangladeshi Payment</h1>
        <p class="order-desc">
            Fast express grocery checkout for Rajshahi city households. Pay securely via bKash, Nagad, Rocket, Upay, or Cash on Delivery.
        </p>
    </div>
</div>

<div class="container">
    <form action="{{ route('order.store') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="items_data" id="items-data-input">
        <input type="hidden" name="order_total" id="order-total-input">

        <div class="checkout-layout">
            <!-- Left Column: Delivery & Payment Details -->
            <div>
                <!-- Delivery Details Card -->
                <div class="checkout-card">
                    <h2 class="card-heading">
                        <span>📍 1. Delivery Details (Rajshahi City)</span>
                    </h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="customer_name">Full Name (আপনার নাম) *</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="e.g., Emon Ahmed" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number (মোবাইল নম্বর) *</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="017XXXXXXXX" value="01712345678" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="zone">Rajshahi Delivery Zone *</label>
                            <select id="zone" name="zone" class="form-control" required>
                                @foreach($zones as $key => $label)
                                    <option value="{{ $key }}" {{ $key === 'Shaheb Bazar' ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="delivery_slot">Preferred Delivery Slot *</label>
                            <select id="delivery_slot" name="delivery_slot" class="form-control" required>
                                <option value="Express (45-60 Mins)">⚡ Express Delivery (Within 45–60 Mins)</option>
                                <option value="Morning Slot (8:00 AM - 11:00 AM)">Morning Slot (8:00 AM – 11:00 AM)</option>
                                <option value="Afternoon Slot (2:00 PM - 5:00 PM)">Afternoon Slot (2:00 PM – 5:00 PM)</option>
                                <option value="Evening Slot (6:00 PM - 9:00 PM)">Evening Slot (6:00 PM – 9:00 PM)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="address">Full Street Address / House / Flat No. *</label>
                        <textarea id="address" name="address" class="form-control" rows="2" placeholder="e.g., House #12, Road #3, Sector #1, Housing Upashahar, Rajshahi" required>Holding #45, Station Road, Shaheb Bazar, Rajshahi</textarea>
                    </div>
                </div>

                <!-- Bangladeshi Payment Methods Card -->
                <div class="checkout-card">
                    <h2 class="card-heading">
                        <span>💳 2. Select Bangladeshi Payment Method</span>
                    </h2>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 12px;">
                        Choose your preferred local mobile wallet, card, or pay cash upon doorstep inspection.
                    </p>

                    <div class="payment-methods-grid">
                        @foreach($paymentMethods as $index => $pay)
                            <label class="payment-option {{ $index === 0 ? 'selected' : '' }}" onclick="selectPayment('{{ $pay['id'] }}', this)">
                                <input type="radio" name="payment_method" value="{{ $pay['id'] }}" {{ $index === 0 ? 'checked' : '' }}>
                                <div>
                                    <div class="pay-title-wrap">
                                        <span>{{ $pay['icon'] }}</span>
                                        <span style="color: {{ $pay['color'] }}; font-weight: 800;">{{ $pay['name'] }}</span>
                                    </div>
                                    <span class="pay-badge-pill">{{ $pay['badge'] }}</span>
                                    <p style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.3;">
                                        {{ $pay['description'] }}
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <!-- Payment Instruction Box -->
                    <div id="payment-instruction-box" style="margin-top: 20px; padding: 15px; border-radius: var(--radius-sm); background: #fdf2f8; border-left: 4px solid #e2136e; font-size: 0.88rem;">
                        <strong>bKash Payment Notice:</strong> You can pay directly from your bKash wallet to our merchant account <code>01712-345678</code> or click Place Order to open the simulated bKash checkout window.
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary & Review -->
            <div>
                <div class="checkout-card" style="position: sticky; top: 90px;">
                    <h2 class="card-heading">
                        <span>🛒 Order Summary</span>
                    </h2>

                    <!-- Items List Container -->
                    <div id="cart-items-display" style="max-height: 280px; overflow-y: auto; margin-bottom: 15px; padding-right: 5px;">
                        <!-- Rendered dynamically by JavaScript -->
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <a href="{{ route('items') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary);">
                            + Add More Grocery Items (Page 2)
                        </a>
                        <button type="button" onclick="CartManager.clearCart(); renderCheckoutCart();" style="background: none; border: none; font-size: 0.8rem; color: #ef4444; cursor: pointer; font-weight: 600;">
                            Clear All
                        </button>
                    </div>

                    <!-- Price Calculations -->
                    <div class="order-summary-box">
                        <div class="summary-line">
                            <span>Items Subtotal</span>
                            <strong id="summary-subtotal">৳0</strong>
                        </div>
                        <div class="summary-line">
                            <span>Delivery Fee (Rajshahi)</span>
                            <strong id="summary-delivery">৳50</strong>
                        </div>
                        <div style="font-size: 0.78rem; color: #059669; font-weight: 700; margin-bottom: 8px;">
                            * Free Delivery on all Rajshahi orders above ৳500!
                        </div>
                        <div class="summary-line grand-total">
                            <span>Grand Total</span>
                            <span id="summary-grand-total">৳0</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-accent" id="btn-place-order" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 20px; box-shadow: var(--shadow-lg);">
                        🛍️ Confirm & Place Order Now
                    </button>

                    <div style="margin-top: 15px; text-align: center; font-size: 0.8rem; color: var(--text-muted);">
                        🔒 100% Safe Bangladeshi Payment & Fresh Doorstep Inspection
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Interactive bKash / Payment Modal Simulation -->
<div class="pay-modal" id="pay-modal">
    <div class="pay-modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.5rem;" id="modal-icon">📱</span>
                <h3 style="font-size: 1.25rem; font-weight: 800;" id="modal-title">bKash Payment Gateway</h3>
            </div>
            <button type="button" onclick="closePayModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
        </div>

        <div style="background: #f8fafc; padding: 15px; border-radius: var(--radius-sm); margin-bottom: 18px;">
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px;">
                <span>Merchant:</span>
                <strong>Rajshahi Bazaar Ltd</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; color: #059669;">
                <span>Payable Amount:</span>
                <span id="modal-amount">৳0</span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" id="modal-wallet-label">Your bKash Wallet Number:</label>
            <input type="text" class="form-control" id="modal-wallet-input" value="01712345678" placeholder="01XXXXXXXXX">
        </div>

        <div class="form-group">
            <label class="form-label">Enter 4-Digit Verification OTP / PIN:</label>
            <input type="password" class="form-control" value="1234" placeholder="••••">
        </div>

        <button type="button" class="btn btn-primary" style="width: 100%; padding: 12px; margin-top: 10px;" onclick="confirmModalPayment()">
            ✅ Complete Payment & Submit Order
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sample default items if cart is initially empty
    const defaultSampleItems = [
        { id: 'deal-1', name: 'Fresh Deshi Tomato (টমেটো)', price: 60, unit: '1 kg', quantity: 2, image: 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=200&q=80' },
        { id: 'deal-2', name: 'Miniket Premium Rice (মিনিকেট চাল)', price: 78, unit: '1 kg', quantity: 3, image: 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=200&q=80' },
        { id: 'deal-3', name: 'Rupchanda Soybean Oil (সয়াবিন তেল)', price: 185, unit: '1 Litre', quantity: 1, image: 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=200&q=80' },
    ];

    function renderCheckoutCart() {
        let items = CartManager.getItems();
        if (items.length === 0) {
            // Seed with sample items so user has instant test data
            defaultSampleItems.forEach(i => CartManager.addItem(i));
            items = CartManager.getItems();
        }

        const container = document.getElementById('cart-items-display');
        container.innerHTML = '';

        let subtotal = 0;

        items.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            const div = document.createElement('div');
            div.className = 'cart-item-row';
            div.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                <div style="flex: 1;">
                    <strong style="display: block; font-size: 0.9rem; color: #0f172a;">${item.name}</strong>
                    <span style="font-size: 0.8rem; color: #64748b;">৳${item.price} / ${item.unit}</span>
                </div>
                <div class="cart-qty-ctrl">
                    <button type="button" class="cart-qty-btn" onclick="CartManager.updateQuantity('${item.id}', -1); renderCheckoutCart();">-</button>
                    <span class="cart-qty-num">${item.quantity}</span>
                    <button type="button" class="cart-qty-btn" onclick="CartManager.updateQuantity('${item.id}', 1); renderCheckoutCart();">+</button>
                </div>
                <div style="font-weight: 800; font-size: 0.95rem; color: #047857; min-width: 60px; text-align: right;">
                    ৳${itemTotal.toLocaleString()}
                </div>
            `;
            container.appendChild(div);
        });

        const deliveryFee = subtotal >= 500 ? 0 : 50;
        const grandTotal = subtotal + deliveryFee;

        document.getElementById('summary-subtotal').textContent = `৳${subtotal.toLocaleString()}`;
        document.getElementById('summary-delivery').textContent = deliveryFee === 0 ? 'FREE' : `৳${deliveryFee}`;
        document.getElementById('summary-grand-total').textContent = `৳${grandTotal.toLocaleString()}`;

        document.getElementById('items-data-input').value = JSON.stringify(items);
        document.getElementById('order-total-input').value = subtotal;
    }

    function selectPayment(id, element) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        
        const notice = document.getElementById('payment-instruction-box');
        if (id === 'bkash') {
            notice.style.background = '#fdf2f8';
            notice.style.borderLeftColor = '#e2136e';
            notice.innerHTML = `<strong>bKash Selected:</strong> Instant payment via personal/merchant wallet. Cashback of 1.5% will apply automatically.`;
        } else if (id === 'nagad') {
            notice.style.background = '#fff7ed';
            notice.style.borderLeftColor = '#f7941d';
            notice.innerHTML = `<strong>Nagad Selected:</strong> Secure digital payment via Nagad postal gateway with 0% gateway charge.`;
        } else if (id === 'rocket') {
            notice.style.background = '#faf5ff';
            notice.style.borderLeftColor = '#8c3494';
            notice.innerHTML = `<strong>DBBL Rocket Selected:</strong> Pay from your 12-digit Dutch-Bangla Rocket mobile banking account.`;
        } else if (id === 'upay') {
            notice.style.background = '#eff6ff';
            notice.style.borderLeftColor = '#0056b3';
            notice.innerHTML = `<strong>Upay Selected:</strong> Fast digital payment powered by United Commercial Bank (UCB).`;
        } else if (id === 'cod') {
            notice.style.background = '#f0fdf4';
            notice.style.borderLeftColor = '#059669';
            notice.innerHTML = `<strong>Cash on Delivery (COD) Selected:</strong> Pay in cash to our Rajshahi delivery hero after checking all fresh grocery items.`;
        } else {
            notice.style.background = '#f8fafc';
            notice.style.borderLeftColor = '#1e293b';
            notice.innerHTML = `<strong>Card Payment Selected:</strong> Visa, Mastercard & Amex accepted via SSLCommerz gateway.`;
        }
    }

    function openPayModal(method) {
        const subtotal = parseFloat(document.getElementById('order-total-input').value) || 560;
        const deliveryFee = subtotal >= 500 ? 0 : 50;
        const grandTotal = subtotal + deliveryFee;

        document.getElementById('modal-amount').textContent = `৳${grandTotal.toLocaleString()}`;
        document.getElementById('modal-title').textContent = `${method.toUpperCase()} Payment Gateway`;
        document.getElementById('modal-wallet-label').textContent = `Your ${method.toUpperCase()} Wallet Number:`;
        document.getElementById('pay-modal').style.display = 'flex';
    }

    function closePayModal() {
        document.getElementById('pay-modal').style.display = 'none';
    }

    function confirmModalPayment() {
        closePayModal();
        document.getElementById('checkout-form').submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutCart();
        window.addEventListener('cartUpdated', renderCheckoutCart);

        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', (e) => {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (['bkash', 'nagad', 'rocket', 'upay'].includes(selectedMethod)) {
                e.preventDefault();
                openPayModal(selectedMethod);
            }
        });
    });
</script>
@endsection
