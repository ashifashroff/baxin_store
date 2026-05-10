<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction ?? 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Baxin Store')</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Bagisto Default CSS + JS (Vue app, components, product grid) -->
    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'shop')

    @stack('styles')
</head>
<body class="font-sans bg-white text-gray-900 antialiased">

<div id="app">
    @include('baxin-modern::layouts.header')

    <main class="min-h-screen">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        @yield('content')

        {!! view_render_event('bagisto.shop.layout.body.after') !!}
    </main>

    @include('baxin-modern::layouts.footer')
</div>

    @stack('scripts')

    <!-- Tailwind CSS CDN (loaded LAST, after Vue app mounts, preflight disabled) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false
            },
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        accent: '#2563EB',
                        'accent-hover': '#1d4ed8',
                    },
                    maxWidth: {
                        '8xl': '1320px',
                    }
                }
            }
        }
    </script>

    <!-- Baxin Modern Custom Overrides -->
    <link rel="stylesheet" href="https://baxin.store/themes/baxin-modern/assets/css/app.css">
<script>
function quickAddToCart(productId) {
    fetch('{{ route("shop.api.checkout.cart.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            showToast('✅ Added to cart!', 'success');
            updateCartCount();
        }
    })
    .catch(() => showToast('❌ Could not add to cart', 'error'));
}

function addToWishlist(productId) {
    fetch('{{ route("shop.api.customers.account.wishlist.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(() => showToast('❤️ Added to wishlist!', 'success'))
    .catch(() => showToast('Sign in to save items', 'info'));
}

function updateCartCount() {
    fetch('{{ route("shop.api.checkout.cart.index") }}')
    .then(res => res.json())
    .then(data => {
        const badge = document.querySelector('.cart-count-badge');
        if (badge) badge.textContent = data.data?.items_count ?? 0;
    });
}

function showToast(message, type = 'success') {
    const colors = {
        success: 'bg-gray-900 text-white',
        error: 'bg-red-500 text-white',
        info: 'bg-blue-500 text-white',
    };
    const toast = document.createElement('div');
    toast.className = `fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-full text-sm font-medium shadow-lg transition-all ${colors[type]}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

{{-- Toast container --}}
<div id="toast-container" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex flex-col gap-2 pointer-events-none"></div>

</body>
</html>
