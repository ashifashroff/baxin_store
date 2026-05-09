@php
    $categories = app(\Webkul\Category\Repositories\CategoryRepository::class)
        ->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);

    $cartCount = auth()->guard('customer')->check()
        ? app(\Webkul\Checkout\Facades\Cart::class)->getCart()?->items_count ?? 0
        : (session('cart_count') ?? 0);

    $customer = auth()->guard('customer')->user();
@endphp

{{-- ① TOPBAR --}}
<div class="bg-gray-900 text-white text-xs py-2 overflow-hidden">
    <div class="flex animate-marquee whitespace-nowrap">
        @foreach([
            '🚚 Free shipping on orders over $49',
            '🔥 Flash deals updated daily — don\'t miss out',
            '📦 Easy 30-day returns on all orders',
            '🎮 New RC Drones just landed — Shop now',
            '🤖 RC Robots on sale this week only',
        ] as $msg)
            <span class="mx-10">{{ $msg }}</span>
        @endforeach
        {{-- Duplicate for seamless loop --}}
        @foreach([
            '🚚 Free shipping on orders over $49',
            '🔥 Flash deals updated daily — don\'t miss out',
            '📦 Easy 30-day returns on all orders',
            '🎮 New RC Drones just landed — Shop now',
            '🤖 RC Robots on sale this week only',
        ] as $msg)
            <span class="mx-10">{{ $msg }}</span>
        @endforeach
    </div>
</div>

{{-- ② MAIN HEADER --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-4 h-16">

            {{-- Logo --}}
            <a href="{{ route('shop.home.index') }}" class="shrink-0 flex items-center gap-1">
                <span class="text-xl font-bold text-gray-900 tracking-tight">Baxin</span>
                <span class="text-xl font-light text-blue-600">.store</span>
            </a>

            {{-- Search Bar --}}
            <form action="{{ route('shop.search.index') }}" method="GET" class="flex-1 max-w-2xl mx-auto">
                <div class="flex items-center border border-gray-200 rounded-full overflow-hidden hover:border-blue-400 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition bg-gray-50">

                    {{-- Category filter dropdown --}}
                    <select name="category" class="hidden sm:block bg-transparent text-xs text-gray-500 pl-4 pr-2 py-2.5 border-r border-gray-200 outline-none cursor-pointer">
                        <option value="">All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="term"
                        value="{{ request('term') }}"
                        placeholder="Search RC drones, robots, toys..."
                        class="flex-1 bg-transparent text-sm text-gray-700 px-4 py-2.5 outline-none placeholder-gray-400" />

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-2.5 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Action Icons --}}
            <div class="flex items-center gap-1 shrink-0">

                {{-- Wishlist --}}
                <a href="{{ route('shop.customers.account.wishlist.index') }}"
                   class="relative w-10 h-10 flex items-center justify-center text-gray-500 hover:text-red-400 hover:bg-red-50 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                    </svg>
                </a>

                {{-- Account --}}
                <div class="relative group">
                    <button class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                    {{-- Account Dropdown --}}
                    <div class="absolute right-0 top-full mt-1 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        @if($customer)
                            <div class="px-4 py-2 border-b border-gray-50">
                                <p class="text-xs font-medium text-gray-900 truncate">{{ $customer->first_name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $customer->email }}</p>
                            </div>
                            <a href="{{ route('shop.customers.account.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition">My Account</a>
                            <a href="{{ route('shop.customers.account.orders.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition">My Orders</a>
                            <a href="{{ route('shop.customers.account.wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition">Wishlist</a>
                            <div class="border-t border-gray-50 mt-1 pt-1">
                                <a href="{{ route('shop.customers.session.destroy') }}" class="block px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">Sign Out</a>
                            </div>
                        @else
                            <a href="{{ route('shop.customers.session.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition">Sign In</a>
                            <a href="{{ route('shop.customers.register.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition">Create Account</a>
                        @endif
                    </div>
                </div>

                {{-- Cart --}}
                <a href="{{ route('shop.checkout.cart.index') }}"
                   class="relative w-10 h-10 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M10 21a1 1 0 1 0 2 0M17 21a1 1 0 1 0 2 0"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-blue-600 text-white text-xs font-bold w-4 h-4 rounded-full flex items-center justify-center leading-none">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Mobile menu toggle --}}
                <button onclick="toggleMobileMenu()"
                        class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-900 rounded-full transition ml-1">
                    <svg id="menu-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- ③ CATEGORY MEGAMENU NAV --}}
<nav class="bg-white border-b border-gray-100 hidden lg:block sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4">
        <ul class="flex items-center gap-1">

            {{-- All Categories --}}
            <li class="relative group">
                <button class="flex items-center gap-1.5 text-sm font-medium text-white bg-blue-600 px-4 py-3 hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    All Categories
                </button>
                {{-- Mega dropdown --}}
                <div class="absolute left-0 top-full w-64 bg-white border border-gray-100 shadow-xl rounded-b-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.product_or_category.index', $cat->slug) }}"
                           class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition group/item">
                            <span>{{ $cat->name }}</span>
                            @if($cat->children->count())
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/item:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            @endif
                        </a>
                    @endforeach
                </div>
            </li>

            {{-- Top category quick links --}}
            @foreach(['RC Drones','RC Robot','RC Vehicles','Dolls & Stuffed Toys','RC Parts'] as $name)
                @php
                    $slug = strtolower(str_replace([' ', '&', '\''], ['-', '', ''], $name));
                    $isActive = request()->segment(1) === $slug;
                @endphp
                <li>
                    <a href="/{{ $slug }}"
                       class="block text-sm px-4 py-3 transition whitespace-nowrap
                       {{ $isActive
                           ? 'text-blue-600 font-medium border-b-2 border-blue-600'
                           : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-200' }}">
                        {{ $name }}
                    </a>
                </li>
            @endforeach

            {{-- Deals --}}
            <li>
                <a href="/special-offers"
                   class="block text-sm px-4 py-3 text-red-500 font-medium hover:text-red-600 transition whitespace-nowrap">
                    ⚡ Flash Deals
                </a>
            </li>

            {{-- New Arrivals --}}
            <li>
                <a href="/new-arrivals"
                   class="block text-sm px-4 py-3 text-gray-600 hover:text-blue-600 transition whitespace-nowrap">
                    ✨ New Arrivals
                </a>
            </li>

        </ul>
    </div>
</nav>

{{-- ④ MOBILE MENU --}}
<div id="mobile-menu"
     class="lg:hidden fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40" onclick="toggleMobileMenu()"></div>

    {{-- Drawer --}}
    <div class="absolute left-0 top-0 bottom-0 w-72 bg-white shadow-2xl flex flex-col">

        {{-- Drawer header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <span class="font-bold text-gray-900">Baxin<span class="font-light text-blue-600">.store</span></span>
            <button onclick="toggleMobileMenu()" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </div>

        {{-- Mobile search --}}
        <div class="p-4 border-b border-gray-100">
            <form action="{{ route('shop.search.index') }}" method="GET">
                <div class="flex items-center border border-gray-200 rounded-full overflow-hidden">
                    <input type="text" name="term" placeholder="Search..."
                           class="flex-1 text-sm px-4 py-2 outline-none" />
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 text-sm">Go</button>
                </div>
            </form>
        </div>

        {{-- Mobile nav links --}}
        <div class="flex-1 overflow-y-auto py-2">
            @foreach($categories as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat->slug) }}"
                   class="flex items-center justify-between px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-50">
                    {{ $cat->name }}
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endforeach
            <a href="/special-offers" class="flex items-center px-5 py-3 text-sm text-red-500 font-medium hover:bg-red-50 transition">
                ⚡ Flash Deals
            </a>
            <a href="/new-arrivals" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition">
                ✨ New Arrivals
            </a>
        </div>

        {{-- Mobile account footer --}}
        <div class="border-t border-gray-100 p-4 space-y-2">
            @if($customer)
                <p class="text-xs text-gray-500 mb-2">Signed in as <strong>{{ $customer->first_name }}</strong></p>
                <a href="{{ route('shop.customers.account.index') }}"
                   class="block w-full text-center text-sm bg-blue-600 text-white py-2.5 rounded-full hover:bg-blue-700 transition">
                    My Account
                </a>
                <a href="{{ route('shop.customers.session.destroy') }}"
                   class="block w-full text-center text-sm text-gray-400 py-1.5 hover:text-red-500 transition">
                    Sign Out
                </a>
            @else
                <a href="{{ route('shop.customers.session.index') }}"
                   class="block w-full text-center text-sm bg-blue-600 text-white py-2.5 rounded-full hover:bg-blue-700 transition">
                    Sign In
                </a>
                <a href="{{ route('shop.customers.register.index') }}"
                   class="block w-full text-center text-sm border border-gray-200 text-gray-600 py-2.5 rounded-full hover:border-blue-400 hover:text-blue-600 transition">
                    Create Account
                </a>
            @endif
        </div>
    </div>
</div>

{{-- Marquee + Mobile menu styles & scripts --}}
@push('styles')
<style>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-marquee {
    animation: marquee 30s linear infinite;
}
.animate-marquee:hover {
    animation-play-state: paused;
}
</style>
@endpush

@push('scripts')
<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
}
</script>
@endpush
