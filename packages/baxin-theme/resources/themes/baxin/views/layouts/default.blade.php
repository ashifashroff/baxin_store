<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction ?? 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Bagisto">

    @stack('meta')

    <link rel="icon" sizes="16x16" href="{{ bagisto_asset('images/favicon.ico') }}">

    @bagistoVite(['resources/assets/css/baxin.css', 'resources/assets/js/baxin.js'], 'baxin')

    @stack('styles')
</head>
<body class="baxin-theme bg-background text-on-background">

    {{-- Top Bar --}}
    <div class="baxin-topbar bg-primary text-on-primary text-xs">
        <div class="baxin-container flex items-center justify-between h-8">
            <div class="flex items-center gap-4">
                <span>🌍 Free Shipping on Orders Over $50</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('shop.customers.account.profile.index') }}" class="hover:text-secondary transition">My Account</a>
                <span>|</span>
                <a href="{{ route('shop.home.index') }}" class="hover:text-secondary transition">Track Order</a>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="baxin-header bg-white shadow-sm sticky top-0 z-50">
        <div class="baxin-container flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('shop.home.index') }}" class="flex-shrink-0">
                @php $logo = core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg'); @endphp
                <img src="{{ $logo }}" alt="{{ config('app.name') }}" class="h-8">
            </a>

            {{-- Search Bar --}}
            <form action="{{ route('shop.search.index') }}" class="baxin-search flex-1 max-w-xl mx-8" role="search">
                <div class="relative">
                    <input type="text" name="query" value="{{ request('query') }}"
                        class="w-full h-10 pl-4 pr-10 rounded-full border border-gray-300 bg-gray-50 text-sm focus:border-accent focus:ring-1 focus:ring-accent"
                        placeholder="Search products..."
                        minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                        maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}">
                    <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Header Icons --}}
            <div class="flex items-center gap-5">
                @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    <a href="{{ route('shop.checkout.cart.index') }}" class="relative text-gray-600 hover:text-accent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span class="absolute -top-1 -right-1 bg-secondary text-on-secondary text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold" v-cloak v-text="cartItemCount"></span>
                    </a>
                @endif

                <x-shop::dropdown position="bottom-right">
                    <x-slot:toggle>
                        <svg class="w-6 h-6 text-gray-600 hover:text-accent cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </x-slot>
                    <x-slot:content>
                        @guest('customer')
                            <div class="p-4 text-center">
                                <p class="font-medium mb-2">Welcome!</p>
                                <a href="{{ route('shop.customer.session.create') }}" class="baxin-btn baxin-btn-primary block mb-2">Sign In</a>
                                <a href="{{ route('shop.customers.register.index') }}" class="baxin-btn baxin-btn-outline block">Register</a>
                            </div>
                        @endguest
                        @auth('customer')
                            <div class="p-2">
                                <a href="{{ route('shop.customers.account.profile.index') }}" class="block px-3 py-2 hover:bg-gray-50 rounded">My Account</a>
                                <a href="{{ route('shop.customers.account.orders.index') }}" class="block px-3 py-2 hover:bg-gray-50 rounded">Orders</a>
                                <form method="POST" action="{{ route('shop.customer.session.destroy') }}" id="logout-form"></form>
                                <a href="#" onclick="document.getElementById('logout-form').submit()" class="block px-3 py-2 hover:bg-gray-50 rounded text-danger">Logout</a>
                            </div>
                        @endauth
                    </x-slot>
                </x-shop::dropdown>
            </div>
        </div>

        {{-- Category Navigation --}}
        <nav class="baxin-nav bg-primary">
            <div class="baxin-container">
                <v-baxin-mega-menu>
                    <div class="flex items-center h-10 gap-1">
                        <span class="w-20 h-4 rounded shimmer" v-if="isLoading"></span>
                        <span class="w-20 h-4 rounded shimmer" v-if="isLoading"></span>
                    </div>
                </v-baxin-mega-menu>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main class="baxin-main min-h-screen">
        @visual_layout_content
        {{ $slot ?? '' }}
    </main>

    {{-- Footer --}}
    <footer class="baxin-footer bg-primary text-on-primary mt-12">
        <div class="baxin-container py-12">
            <div class="grid grid-cols-4 gap-8 max-md:grid-cols-2 max-sm:grid-cols-1">
                {{-- About --}}
                <div>
                    <img src="{{ $logo }}" alt="Baxin.Store" class="h-8 mb-4 brightness-0 invert">
                    <p class="text-sm text-gray-300">Global leading online shop for RC toys, RC spares, RC parts and accessories.</p>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="text-gray-300 hover:text-secondary"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#" class="text-gray-300 hover:text-secondary"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                        <a href="#" class="text-gray-300 hover:text-secondary"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                    </div>
                </div>

                {{-- Categories --}}
                <div>
                    <h4 class="font-bold text-secondary mb-4 uppercase text-sm">Categories</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('shop.product_or_category.index', 'rc-drones') }}" class="hover:text-secondary transition">RC Drones</a></li>
                        <li><a href="{{ route('shop.product_or_category.index', 'rc-vehicles') }}" class="hover:text-secondary transition">RC Vehicles</a></li>
                        <li><a href="{{ route('shop.product_or_category.index', 'rc-parts') }}" class="hover:text-secondary transition">RC Parts</a></li>
                        <li><a href="{{ route('shop.product_or_category.index', 'musical-instruments') }}" class="hover:text-secondary transition">Musical Instruments</a></li>
                        <li><a href="{{ route('shop.product_or_category.index', 'model-building-toys') }}" class="hover:text-secondary transition">Model & Building Toys</a></li>
                    </ul>
                </div>

                {{-- Customer Service --}}
                <div>
                    <h4 class="font-bold text-secondary mb-4 uppercase text-sm">Customer Service</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-secondary transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-secondary transition">Shipping Policy</a></li>
                        <li><a href="#" class="hover:text-secondary transition">Return Policy</a></li>
                        <li><a href="#" class="hover:text-secondary transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-secondary transition">Privacy Policy</a></li>
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div>
                    <h4 class="font-bold text-secondary mb-4 uppercase text-sm">Newsletter</h4>
                    <p class="text-sm text-gray-300 mb-3">Subscribe for deals & new arrivals</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="flex-1 h-9 px-3 rounded-l text-sm text-gray-800 focus:outline-none">
                        <button type="submit" class="bg-secondary text-on-secondary px-4 h-9 rounded-r text-sm font-bold hover:opacity-90">→</button>
                    </form>
                    <div class="mt-4 text-sm text-gray-300">
                        <p>📧 support@baxin.store</p>
                        <p class="mt-1">🕐 Mon-Fri 9AM-6PM JST</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-600">
            <div class="baxin-container py-4 flex items-center justify-between text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} Baxin.Store. All rights reserved.</p>
                <div class="flex gap-4">
                    <span>💳 Visa</span>
                    <span>💳 Mastercard</span>
                    <span>💳 PayPal</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
