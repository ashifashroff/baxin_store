/* Baxin Banggood Theme — App JS */

(function() {
    'use strict';

    // ===== Mobile drawer =====
    var menuBtn = document.getElementById('mobile-menu-btn');
    var drawer = document.getElementById('mobile-drawer');
    var drawerPanel = document.getElementById('drawer-panel');
    var overlay = document.getElementById('drawer-overlay');
    var closeBtn = document.getElementById('close-drawer');

    function openDrawer() {
        drawer.classList.remove('hidden');
        setTimeout(function() { drawerPanel.style.transform = 'translateX(0)'; }, 10);
    }
    function closeDrawer() {
        drawerPanel.style.transform = 'translateX(-100%)';
        setTimeout(function() { drawer.classList.add('hidden'); }, 300);
    }

    if (menuBtn) menuBtn.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    // ===== Add to Cart =====
    window.addToCart = function(productId) {
        var qtyEl = document.getElementById('qty');
        var qty = qtyEl ? Math.max(1, parseInt(qtyEl.value) || 1) : 1;

        fetch('/api/checkout/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
            },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.message) {
                showToast(data.message, 'success');
            } else {
                showToast('Added to cart!', 'success');
            }
        })
        .catch(function() {
            showToast('Error adding to cart', 'error');
        });
    };

    // ===== Wishlist =====
    window.toggleWishlist = function(productId) {
        fetch('/api/wishlist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            showToast(data.message || 'Updated wishlist', 'success');
        })
        .catch(function() {
            showToast('Please sign in to use wishlist', 'info');
        });
    };

    // ===== Toast notifications =====
    window.showToast = function(message, type) {
        type = type || 'info';
        var container = document.getElementById('toast-container');
        if (!container) return;

        var colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-brand-600'
        };

        var toast = document.createElement('div');
        toast.className = (colors[type] || colors.info) + ' text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium transform translate-x-full transition-transform duration-300';
        toast.textContent = message;
        container.appendChild(toast);

        setTimeout(function() { toast.style.transform = 'translateX(0)'; }, 10);
        setTimeout(function() {
            toast.style.transform = 'translateX(120%)';
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    };

    // ===== Sticky header shadow on scroll =====
    var header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
    }

})();
