// Shared Rajshahi Groceries Cart & UI Manager
const CartManager = {
    key: 'rajshahi_bazaar_cart',
    
    getItems() {
        try {
            return JSON.parse(localStorage.getItem(this.key)) || [];
        } catch (e) {
            return [];
        }
    },
    
    saveItems(items) {
        localStorage.setItem(this.key, JSON.stringify(items));
        this.updateBadge();
        window.dispatchEvent(new CustomEvent('cartUpdated', { detail: { items } }));
    },
    
    addItem(item) {
        let items = this.getItems();
        const existing = items.find(i => i.id === item.id);
        if (existing) {
            existing.quantity += item.quantity || 1;
        } else {
            items.push({
                id: item.id,
                name: item.name,
                bengaliName: item.bengaliName || '',
                price: parseFloat(item.price),
                unit: item.unit,
                image: item.image,
                quantity: item.quantity || 1
            });
        }
        this.saveItems(items);
        this.showToast(`✅ "${item.name}" added to cart!`);
    },
    
    updateQuantity(id, delta) {
        let items = this.getItems();
        const existing = items.find(i => i.id === id);
        if (existing) {
            existing.quantity += delta;
            if (existing.quantity <= 0) {
                items = items.filter(i => i.id !== id);
            }
            this.saveItems(items);
        }
    },
    
    removeItem(id) {
        let items = this.getItems().filter(i => i.id !== id);
        this.saveItems(items);
    },
    
    clearCart() {
        localStorage.removeItem(this.key);
        this.updateBadge();
        window.dispatchEvent(new CustomEvent('cartUpdated', { detail: { items: [] } }));
    },
    
    getTotalCount() {
        return this.getItems().reduce((sum, item) => sum + item.quantity, 0);
    },
    
    getSubtotal() {
        return this.getItems().reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },
    
    updateBadge() {
        const badges = document.querySelectorAll('.cart-badge');
        const count = this.getTotalCount();
        badges.forEach(b => {
            b.textContent = count;
            b.style.display = count > 0 ? 'inline-block' : 'inline-block';
        });
    },
    
    showToast(message) {
        let toast = document.getElementById('cart-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cart-toast';
            toast.className = 'toast-notification';
            document.body.appendChild(toast);
        }
        toast.innerHTML = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2800);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    CartManager.updateBadge();
    
    // Listen for add-to-cart clicks
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-add-cart');
        if (btn) {
            const productCard = btn.closest('[data-product-id]');
            if (productCard) {
                const item = {
                    id: productCard.dataset.productId,
                    name: productCard.dataset.productName,
                    bengaliName: productCard.dataset.productBengali || '',
                    price: productCard.dataset.productPrice,
                    unit: productCard.dataset.productUnit,
                    image: productCard.dataset.productImage,
                    quantity: 1
                };
                CartManager.addItem(item);
            }
        }
    });
});
