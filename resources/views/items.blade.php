@extends('layouts.app')

@section('title', 'Grocery Items & BD Prices | Rajshahi Bazaar (রাজশাহী বাজার)')
@section('meta_description', 'Browse authentic Bangladeshi grocery items with live photos and BDT (৳) prices. Fresh vegetables, Miniket rice, soybean oil, spices & Padma fish.')

@section('styles')
<style>
    .catalog-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        padding: 45px 0 35px;
        margin-bottom: 30px;
    }
    .catalog-title {
        font-size: 2.3rem;
        font-weight: 800;
        margin-bottom: 8px;
    }
    .catalog-desc {
        font-size: 1.05rem;
        opacity: 0.9;
        max-width: 680px;
    }

    /* Category Pill Filter Bar */
    .filter-scroll-wrapper {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 6px 0 16px;
        scrollbar-width: thin;
    }
    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #ffffff;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-secondary);
        white-space: nowrap;
        transition: var(--transition);
        cursor: pointer;
    }
    .filter-pill:hover {
        border-color: var(--primary);
        color: var(--primary-dark);
        background: var(--primary-light);
    }
    .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 12px var(--primary-glow);
    }

    /* Search & Filter Toolbar */
    .catalog-toolbar {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }
    .toolbar-search {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        max-width: 420px;
    }
    .toolbar-search input {
        width: 100%;
        padding: 9px 16px;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
    }
    .toolbar-search input:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Bottom Floating Cart Bar */
    .floating-cart-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(15, 23, 42, 0.96);
        backdrop-filter: blur(12px);
        color: white;
        padding: 14px 0;
        z-index: 99;
        box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.2);
        display: none;
        animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
    }
    .floating-cart-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endsection

@section('content')
<!-- Catalog Hero Header -->
<div class="catalog-header">
    <div class="container">
        <span class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 12px;">PAGE 2 • GROCERY ITEMS</span>
        <h1 class="catalog-title">Bangladeshi Grocery Items in Rajshahi</h1>
        <p class="catalog-desc">
            Explore daily fresh items with authentic Bangladeshi market prices in BDT (৳), direct farm sourcing, and guaranteed weight precision.
        </p>
    </div>
</div>

<div class="container" style="padding-bottom: 90px;">
    <!-- Category Pills Filter Bar -->
    <div class="filter-scroll-wrapper">
        @foreach($categories as $key => $label)
            <a href="{{ route('items', ['category' => $key, 'search' => $searchQuery]) }}" 
               class="filter-pill {{ $selectedCategory === $key ? 'active' : '' }}">
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </div>

    <!-- Catalog Toolbar -->
    <div class="catalog-toolbar">
        <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-secondary);">
            Showing <span style="color: var(--primary-dark); font-weight: 800;">{{ $totalCount }}</span> Grocery Items 
            @if($selectedCategory !== 'All')
                in <span class="badge badge-green">{{ $selectedCategory }}</span>
            @endif
            @if(!empty($searchQuery))
                matching "<span style="color: var(--accent-dark);">{{ $searchQuery }}</span>"
            @endif
        </div>

        <form action="{{ route('items') }}" method="GET" class="toolbar-search">
            <input type="hidden" name="category" value="{{ $selectedCategory }}">
            <input type="text" name="search" placeholder="Search item by name / বাংলায় খুঁজুন..." value="{{ $searchQuery }}">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.85rem;">Filter</button>
            @if(!empty($searchQuery) || $selectedCategory !== 'All')
                <a href="{{ route('items') }}" class="btn btn-outline" style="padding: 8px 14px; font-size: 0.85rem; border-color: #cbd5e1; color: #64748b;">Reset</a>
            @endif
        </form>
    </div>

    <!-- Product Grid -->
    @if($totalCount > 0)
        <div class="product-grid">
            @foreach($products as $item)
                <div class="product-card"
                     data-product-id="{{ $item['id'] }}"
                     data-product-name="{{ $item['name'] }}"
                     data-product-bengali="{{ $item['bengali_name'] }}"
                     data-product-price="{{ $item['price'] }}"
                     data-product-unit="{{ $item['unit'] }}"
                     data-product-image="{{ $item['image'] }}">
                    
                    @if(!empty($item['discount']))
                        <span class="product-badge-discount">{{ $item['discount'] }}</span>
                    @elseif(!empty($item['badge']))
                        <span class="badge badge-green" style="position: absolute; top: 12px; left: 12px; z-index: 2;">{{ $item['badge'] }}</span>
                    @endif

                    <div class="product-img-wrap">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" loading="lazy">
                    </div>

                    <div class="product-details">
                        <span class="product-category-tag">{{ $item['category'] }}</span>
                        <h3 class="product-title">{{ $item['name'] }}</h3>
                        <p style="font-size: 0.82rem; color: #047857; font-weight: 600; margin-bottom: 4px;">{{ $item['bengali_name'] }}</p>
                        <p class="product-unit">Unit: {{ $item['unit'] }}</p>
                        
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 12px; line-height: 1.4;">
                            {{ $item['description'] }}
                        </p>

                        <div class="product-price-row">
                            <span class="current-price">৳{{ number_format($item['price']) }}</span>
                            @if(!empty($item['old_price']))
                                <span class="old-price">৳{{ number_format($item['old_price']) }}</span>
                            @endif
                        </div>

                        <div class="product-card-actions">
                            <button type="button" class="btn-add-cart">
                                <span>🛒 Add to Cart</span>
                            </button>
                            <a href="{{ route('order') }}" class="btn btn-accent" style="padding: 10px 14px; font-size: 0.85rem;" title="Order Directly">
                                Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: #ffffff; border: 1px dashed var(--border-color); border-radius: var(--radius-md); padding: 50px 20px; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 15px;">🔍</div>
            <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 8px;">No Grocery Items Found</h3>
            <p style="color: var(--text-secondary); margin-bottom: 20px;">We couldn't find any items matching your filter or search criteria.</p>
            <a href="{{ route('items') }}" class="btn btn-primary">View All Available Items</a>
        </div>
    @endif
</div>

<!-- Floating Bottom Cart Bar -->
<div class="floating-cart-bar" id="floating-cart-bar">
    <div class="container floating-cart-inner">
        <div>
            <span style="font-weight: 800; font-size: 1.1rem; color: #34d399;" id="floating-cart-count">0 Items in Cart</span>
            <span style="color: #cbd5e1; margin-left: 12px; font-size: 0.95rem;">Subtotal: <strong style="color: white;" id="floating-cart-total">৳0</strong></span>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" class="btn" style="background: rgba(255,255,255,0.15); color: white; padding: 8px 16px; font-size: 0.85rem;" onclick="CartManager.clearCart()">Clear</button>
            <a href="{{ route('order') }}" class="btn btn-accent" style="padding: 8px 20px; font-size: 0.9rem;">
                Proceed to Checkout (Page 3) ➔
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateFloatingCart() {
        const bar = document.getElementById('floating-cart-bar');
        const countElem = document.getElementById('floating-cart-count');
        const totalElem = document.getElementById('floating-cart-total');
        
        const count = CartManager.getTotalCount();
        const total = CartManager.getSubtotal();
        
        if (count > 0) {
            bar.style.display = 'block';
            countElem.textContent = `${count} ${count === 1 ? 'Item' : 'Items'} in Cart`;
            totalElem.textContent = `৳${total.toLocaleString()}`;
        } else {
            bar.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateFloatingCart();
        window.addEventListener('cartUpdated', updateFloatingCart);
    });
</script>
@endsection
