{{-- Header --}}
<header class="sticky top-0 z-50 bg-white border-b border-gray-100">
    <div class="max-w-8xl mx-auto px-5 flex items-center justify-between h-[60px]">
        <!-- Logo -->
        <a href="{{ route('shop.home.index') }}" class="flex items-center gap-1 no-underline">
            <span class="text-xl font-bold tracking-tight text-gray-900">Baxin</span>
            <span class="text-xl font-light text-accent">Store</span>
        </a>

        <!-- Search -->
        <div class="hidden sm:block flex-1 max-w-xl mx-8 relative">
            <form action="{{ route('shop.search.index') }}">
                <svg class="w-4 h-4 absolute left-4 top-[11px] text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="query" value="{{ request('query') }}"
                    class="w-full h-[38px] pl-10 pr-4 rounded-full border border-gray-200 bg-gray-50 text-sm focus:border-accent focus:ring-2 focus:ring-accent/10 outline-none transition"
                    placeholder="Search products...">
            </form>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-5">
            <a href="{{ route('shop.checkout.cart.index') }}" class="text-gray-500 hover:text-accent transition text-sm font-medium">🛒 Cart</a>
            <a href="{{ route('shop.customers.account.profile.index') }}" class="text-gray-500 hover:text-accent transition text-sm font-medium">👤 Account</a>
        </div>
    </div>
</header>

{{-- Category Nav --}}
<nav class="bg-gray-900">
    <div class="max-w-8xl mx-auto px-5 flex items-center h-10 gap-1 overflow-x-auto scrollbar-hide">
        <a href="{{ route('shop.home.index') }}" class="text-white/85 text-[13px] font-medium px-3.5 py-2 rounded hover:bg-white/10 hover:text-amber-400 transition whitespace-nowrap no-underline">Home</a>
        @php
            $navCategories = app('Webkul\Category\Repositories\CategoryRepository')
                ->findOrFail(141)->children()->where('status', 1)->get();
        @endphp
        @foreach($navCategories as $cat)
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="text-white/85 text-[13px] font-medium px-3.5 py-2 rounded hover:bg-white/10 hover:text-amber-400 transition whitespace-nowrap no-underline">{{ $cat->name }}</a>
        @endforeach
    </div>
</nav>
