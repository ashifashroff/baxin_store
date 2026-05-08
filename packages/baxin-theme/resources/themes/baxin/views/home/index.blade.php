@extends('baxin::layouts.default')

@section('meta')
    <title>Baxin.Store - Global Leading Online Shop for RC Toys, Parts & Accessories</title>
    <meta name="description" content="Shop RC drones, RC vehicles, RC parts, musical instruments, model building toys and more at Baxin.Store. Free shipping on orders over $50.">
@endsection

@section('body')
    {{-- Hero Slider --}}
    <section class="baxin-hero bg-gradient-to-r from-primary via-primary to-accent overflow-hidden">
        <div class="baxin-container py-12">
            <div class="grid grid-cols-2 gap-8 items-center max-md:grid-cols-1">
                <div class="text-white">
                    <h1 class="text-4xl font-bold mb-4 max-md:text-2xl">Explore the World of <span class="text-secondary">RC & Toys</span></h1>
                    <p class="text-lg text-gray-300 mb-6">Discover drones, vehicles, parts, and more at unbeatable prices.</p>
                    <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="baxin-btn baxin-btn-secondary inline-block">Shop Now →</a>
                </div>
                <div class="text-center">
                    <img src="{{ bagisto_asset('images/hero-image.webp') }}" alt="RC Products" class="max-h-80 mx-auto" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- Category Icons --}}
    <section class="baxin-categories py-10">
        <div class="baxin-container">
            <h2 class="text-2xl font-bold mb-6 text-center">Shop by Category</h2>
            <div class="grid grid-cols-6 gap-4 max-md:grid-cols-3 max-sm:grid-cols-2">
                @php
                    $navCategories = app('Webkul\Category\Repositories\CategoryRepository')
                        ->findOrFail(141)->children()->where('status', 1)->get();
                @endphp
                @foreach($navCategories as $cat)
                    <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="baxin-cat-icon flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 transition group">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-2 group-hover:bg-secondary group-hover:text-white transition text-2xl">
                            @if($cat->slug == 'rc-drones') ✈️
                            @elseif($cat->slug == 'rc-vehicles') 🏎️
                            @elseif($cat->slug == 'rc-parts') 🔧
                            @elseif($cat->slug == 'rc-robot') 🤖
                            @elseif($cat->slug == 'musical-instruments') 🎸
                            @elseif($cat->slug == 'model-building-toys') 🧱
                            @elseif($cat->slug == 'learning-education') 📚
                            @elseif($cat->slug == 'dolls-stuffed-toys') 🧸
                            @elseif($cat->slug == 'baby-toddler-toys') 👶
                            @elseif($cat->slug == 'novelty-gagdet-toys') 🎮
                            @elseif($cat->slug == 'sports-outdoor') ⚽
                            @elseif($cat->slug == 'laptop-ac-adapters') 🔌
                            @else 🛒
                            @endif
                        </div>
                        <span class="text-xs font-medium text-center text-gray-700 group-hover:text-accent">{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Hot Deals --}}
    <section class="baxin-deals bg-gray-50 py-10">
        <div class="baxin-container">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">🔥 Hot Deals</h2>
                <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="text-accent hover:underline text-sm">View All →</a>
            </div>
            <div class="product-grid-4">
                @php
                    $dealProducts = app('Webkul\Product\Repositories\ProductRepository')
                        ->with('flat')
                        ->whereHas('flat', fn($q) => $q->where('special_price', '>', 0))
                        ->where('status', 1)
                        ->limit(8)
                        ->get();
                @endphp
                @foreach($dealProducts as $product)
                    @include('baxin::partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    {{-- Banner Ad --}}
    <section class="baxin-banner py-6">
        <div class="baxin-container">
            <div class="bg-gradient-to-r from-accent to-primary rounded-lg p-8 text-white flex items-center justify-between max-md:flex-col max-md:text-center max-md:gap-4">
                <div>
                    <h3 class="text-2xl font-bold">New Arrivals Every Week!</h3>
                    <p class="text-gray-200">Stay updated with the latest RC products and accessories.</p>
                </div>
                <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="baxin-btn baxin-btn-secondary">Browse New Arrivals →</a>
            </div>
        </div>
    </section>

    {{-- New Products --}}
    <section class="baxin-new py-10">
        <div class="baxin-container">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">🆕 New Arrivals</h2>
                <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="text-accent hover:underline text-sm">View All →</a>
            </div>
            <div class="product-grid-4">
                @php
                    $newProducts = app('Webkul\Product\Repositories\ProductRepository')
                        ->with('flat')
                        ->whereHas('flat', fn($q) => $q->where('new', 1))
                        ->where('status', 1)
                        ->limit(8)
                        ->get();
                @endphp
                @foreach($newProducts as $product)
                    @include('baxin::partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
@endsection
