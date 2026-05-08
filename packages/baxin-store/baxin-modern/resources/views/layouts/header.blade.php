<header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="{{ route('shop.home.index') }}" class="flex items-center space-x-2">
                <span class="text-xl font-semibold tracking-tight text-gray-900">Baxin</span>
                <span class="text-xl font-light text-accent">Store</span>
            </a>

            <!-- Nav -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.home.index') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">Home</a>
                @php
                    $navCategories = app('Webkul\Category\Repositories\CategoryRepository')
                        ->findOrFail(141)->children()->where('status', 1)->take(6)->get();
                @endphp
                @foreach($navCategories as $cat)
                    <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="text-sm text-gray-600 hover:text-gray-900 transition">{{ $cat->name }}</a>
                @endforeach
            </nav>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form action="{{ route('shop.search.index') }}" class="hidden sm:flex items-center">
                    <input type="text" name="query" value="{{ request('query') }}"
                        class="w-48 h-9 pl-4 pr-3 text-sm rounded-full border border-gray-200 bg-gray-50 focus:border-accent focus:ring-1 focus:ring-accent outline-none"
                        placeholder="Search...">
                </form>
                <!-- Cart -->
                <a href="{{ route('shop.checkout.cart.index') }}" class="relative text-gray-500 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M10 21a1 1 0 1 0 2 0M17 21a1 1 0 1 0 2 0"/>
                    </svg>
                </a>
                <!-- Account -->
                <a href="{{ route('shop.customers.account.profile.index') }}" class="text-sm font-medium text-gray-700 hover:text-accent transition">Account</a>
            </div>

        </div>
    </div>

    <!-- Mobile Nav -->
    <div class="md:hidden border-t border-gray-100 overflow-x-auto">
        <div class="flex items-center space-x-4 px-4 py-2">
            <a href="{{ route('shop.home.index') }}" class="text-xs text-gray-600 whitespace-nowrap">Home</a>
            @foreach($navCategories ?? [] as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="text-xs text-gray-600 whitespace-nowrap">{{ $cat->name }}</a>
            @endforeach
        </div>
    </div>
</header>
