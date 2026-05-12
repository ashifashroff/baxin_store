{{-- Header inspired by Banggood: Logo | Search | Account/Cart --}}
@php
    $cartCount = 0;
    if (auth()->guard('customer')->check()) {
        try {
            $cart = app(\Webkul\Checkout\Repositories\CartRepository::class)->findOneWhere([
                'customer_id' => auth()->guard('customer')->id(),
                'is_active' => 1,
            ]);
            $cartCount = $cart ? $cart->items_count : 0;
        } catch (\Exception $e) {}
    }
@endphp

{{-- Main header --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-8xl mx-auto px-4">

        {{-- Desktop header --}}
        <div class="hidden md:flex items-center h-16 gap-6">

            {{-- Logo --}}
            <a href="{{ route('shop.home.index') }}" class="flex items-center gap-2 flex-shrink-0 no-underline">
                <span class="text-2xl font-extrabold text-brand-600 tracking-tight">BAXIN</span>
                <span class="text-xs text-gray-400 font-medium tracking-wider mt-1">.STORE</span>
            </a>

            {{-- Search bar — Banggood wide style --}}
            <div class="flex-1 max-w-2xl">
                <form action="{{ route('shop.search.index') }}" method="GET" class="flex">
                    <div class="flex w-full border-2 border-brand-500 rounded-full overflow-hidden focus-within:border-brand-600 transition">
                        <input type="text"
                            name="query"
                            value="{{ request('query') }}"
                            placeholder="Search for RC drones, robots, vehicles, parts..."
                            class="flex-1 px-5 py-2.5 text-sm focus:outline-none bg-white"
                            aria-label="Search products">
                        <button type="submit" class="bg-brand-600 text-white px-6 hover:bg-brand-700 transition flex items-center" aria-label="Search">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-1">
                {{-- Account --}}
                <a href="{{ route('shop.customer.session.create') }}" class="flex flex-col items-center px-3 py-2 text-gray-600 hover:text-brand-600 transition rounded-lg hover:bg-gray-50 no-underline" aria-label="Account">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[10px] mt-0.5">Account</span>
                </a>

                {{-- Wishlist --}}
                <a href="{{ route('shop.customer.wishlist.index') }}" class="flex flex-col items-center px-3 py-2 text-gray-600 hover:text-brand-600 transition rounded-lg hover:bg-gray-50 no-underline" aria-label="Wishlist">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span class="text-[10px] mt-0.5">Wishlist</span>
                </a>

                {{-- Cart --}}
                <a href="{{ route('shop.checkout.cart.index') }}" class="flex flex-col items-center px-3 py-2 text-gray-600 hover:text-brand-600 transition rounded-lg hover:bg-gray-50 no-underline relative" aria-label="Cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 right-1 bg-accent text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                    <span class="text-[10px] mt-0.5">Cart</span>
                </a>
            </div>
        </div>

        {{-- Mobile header --}}
        <div class="flex md:hidden items-center h-14 gap-3">
            <button id="mobile-menu-btn" class="p-2 -ml-2 text-gray-700" aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a href="{{ route('shop.home.index') }}" class="flex items-center no-underline">
                <span class="text-xl font-extrabold text-brand-600">BAXIN</span>
                <span class="text-[10px] text-gray-400 mt-0.5">.STORE</span>
            </a>
            <div class="flex-1"></div>
            <a href="{{ route('shop.search.index') }}" class="p-2 text-gray-600 no-underline" aria-label="Search">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </a>
            <a href="{{ route('shop.checkout.cart.index') }}" class="p-2 text-gray-600 no-underline relative" aria-label="Cart">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                @if($cartCount > 0)
                    <span class="absolute top-0 right-0 bg-accent text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>

    {{-- Category navigation bar --}}
    <div class="bg-gray-900 text-white hidden md:block">
        <div class="max-w-8xl mx-auto px-4">
            <nav class="flex items-center h-10 gap-0 overflow-x-auto" id="category-nav">
                @php
                    $navCats = \Illuminate\Support\Facades\DB::table('categories')
                        ->join('category_translations', function($j) { $j->on('categories.id', '=', 'category_translations.category_id')->where('category_translations.locale', 'en'); })
                        ->where('categories.parent_id', 141)
                        ->select('categories.id', 'categories.slug', 'category_translations.name')
                        ->orderBy('categories.position')
                        ->get();
                @endphp
                @foreach($navCats as $cat)
                    <a href="{{ route('shop.product_or_category.index', $cat->slug) }}"
                       class="px-4 h-10 flex items-center text-sm text-gray-300 hover:text-white hover:bg-gray-800 transition whitespace-nowrap no-underline">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<div id="mobile-drawer" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50" id="drawer-overlay"></div>
    <div class="absolute left-0 top-0 bottom-0 w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300" id="drawer-panel">
        <div class="flex items-center justify-between p-4 border-b">
            <span class="text-lg font-bold text-brand-600">Menu</span>
            <button id="close-drawer" class="p-2 text-gray-500" aria-label="Close menu">✕</button>
        </div>
        <nav class="overflow-y-auto h-[calc(100%-64px)]">
            @foreach($navCats ?? [] as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-brand-600 transition no-underline border-b border-gray-50">
                    {{ $cat->name }}
                </a>
            @endforeach
            <div class="border-t border-gray-200 mt-2">
                <a href="{{ route('shop.customer.session.create') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 no-underline">🔐 Sign In</a>
                <a href="{{ route('shop.customer.register.create') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 no-underline">📝 Register</a>
            </div>
        </nav>
    </div>
</div>
