@extends('layouts.app')

@section('title', 'Order Placed Successfully | Rajshahi Bazaar (রাজশাহী বাজার)')

@section('content')
<div class="container" style="padding: 50px 20px 80px; max-width: 760px;">
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow-lg); text-align: center;">
        
        <div style="width: 72px; height: 72px; border-radius: var(--radius-full); background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px;">
            ✓
        </div>

        <span class="badge badge-green" style="font-size: 0.9rem; margin-bottom: 10px;">ORDER CONFIRMED</span>
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">ধন্যবাদ! আপনার অর্ডারটি গৃহীত হয়েছে</h1>
        <p style="color: var(--text-secondary); font-size: 1.05rem; margin-bottom: 25px;">
            Thank you for ordering with Rajshahi Bazaar. Our delivery rider has been assigned and your fresh groceries are being packed.
        </p>

        <!-- Receipt Card -->
        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: var(--radius-md); padding: 25px; text-align: left; margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 15px;">
                <div>
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 700;">ORDER TRACKING ID</span>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #059669;">#{{ $orderId }}</h3>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 700;">DATE & TIME</span>
                    <p style="font-size: 0.9rem; font-weight: 600;">{{ $createdAt }}</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 0.9rem; margin-bottom: 20px;">
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">CUSTOMER NAME:</strong>
                    <span style="font-weight: 700; color: #0f172a;">{{ $customerName }}</span>
                </div>
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">PHONE NUMBER:</strong>
                    <span style="font-weight: 700; color: #0f172a;">{{ $phone }}</span>
                </div>
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">DELIVERY ZONE & ADDRESS:</strong>
                    <span style="font-weight: 600; color: #0f172a;">{{ $address }} ({{ $zone }})</span>
                </div>
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">DELIVERY SLOT:</strong>
                    <span style="font-weight: 700; color: #047857;">{{ $deliverySlot }}</span>
                </div>
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">PAYMENT METHOD:</strong>
                    <span class="badge" style="background: #e0e7ff; color: #3730a3; font-weight: 800; text-transform: uppercase;">
                        {{ $paymentMethod }}
                    </span>
                </div>
                <div>
                    <strong style="color: #64748b; font-size: 0.8rem; display: block;">DELIVERY STATUS:</strong>
                    <span class="badge badge-green">🚀 Packing & Dispatched</span>
                </div>
            </div>

            <!-- Total Calculation Table -->
            <div style="border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.95rem; margin-bottom: 6px;">
                    <span style="color: #64748b;">Groceries Subtotal:</span>
                    <strong>৳{{ number_format($orderTotal) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.95rem; margin-bottom: 10px;">
                    <span style="color: #64748b;">Delivery Fee (Rajshahi City):</span>
                    <strong style="color: #059669;">{{ $deliveryFee === 0 ? 'FREE' : '৳' . $deliveryFee }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.35rem; font-weight: 800; color: #047857; border-top: 2px dashed #cbd5e1; padding-top: 10px;">
                    <span>Grand Total (সর্বমোট):</span>
                    <span>৳{{ number_format($grandTotal) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <button type="button" onclick="window.print()" class="btn btn-outline" style="border-color: #94a3b8; color: #334155;">
                🖨️ Print Receipt
            </button>
            <a href="{{ route('items') }}" class="btn btn-primary">
                🥦 Continue Shopping (Page 2)
            </a>
            <a href="{{ route('contact') }}" class="btn btn-accent">
                📞 Contact Support (Page 4)
            </a>
        </div>
    </div>
</div>
@endsection
