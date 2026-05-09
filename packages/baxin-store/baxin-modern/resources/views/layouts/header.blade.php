{{-- Header --}}
<header class="baxin-header">
    <div class="baxin-header-inner">
        <a href="{{ route('shop.home.index') }}" class="baxin-logo">
            <span class="baxin-logo-bold">Baxin</span>
            <span class="baxin-logo-light">Store</span>
        </a>

        <div class="baxin-search">
            <span class="baxin-search-icon">🔍</span>
            <form action="{{ route('shop.search.index') }}">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Search products...">
            </form>
        </div>

        <div class="baxin-header-actions">
            <a href="{{ route('shop.checkout.cart.index') }}">🛒 Cart</a>
            <a href="{{ route('shop.customers.account.profile.index') }}">👤 Account</a>
        </div>
    </div>
</header>

{{-- Category Nav --}}
<nav class="baxin-nav">
    <div class="baxin-nav-inner">
        <a href="{{ route('shop.home.index') }}" class="active">Home</a>
        @php
            $navCategories = app('Webkul\Category\Repositories\CategoryRepository')
                ->findOrFail(141)->children()->where('status', 1)->get();
        @endphp
        @foreach($navCategories as $cat)
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</nav>
