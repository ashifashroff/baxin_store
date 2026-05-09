@extends('baxin-modern::layouts.master')

@section('title', 'Baxin Store — RC Toys, Drones & Kids Electronics')

@section('content')

@php
    // Build category blocks
    $targetCategoryNames = ['RC Drones', 'RC Robot', 'RC Vehicles', 'Dolls & Stuffed Toys', 'RC Parts'];
    $categoryBlocks = [];
    foreach ($targetCategoryNames as $catName) {
        $cat = app('Webkul\Category\Repositories\CategoryRepository')->getModel()
            ->whereHas('translation', fn($q) => $q->where('name', $catName))
            ->where('status', 1)->first();
        if (!$cat) continue;
        $pids = DB::table('product_categories')->where('category_id', $cat->id)->pluck('product_id');
        $prods = app('Webkul\Product\Repositories\ProductFlatRepository')->getModel()
            ->whereIn('id', $pids)->where('locale', app()->getLocale())->where('status', 1)
            ->orderBy('created_at', 'desc')->take(5)->get();
        if ($prods->isEmpty()) continue;
        $categoryBlocks[] = ['name' => $catName, 'slug' => $cat->slug, 'products' => $prods];
    }

    // Flash deals
    $flashDeals = app('Webkul\Product\Repositories\ProductFlatRepository')->getModel()
        ->where('locale', app()->getLocale())->where('status', 1)
        ->whereNotNull('special_price')->where('special_price', '>', 0)
        ->orderBy('special_price', 'asc')->take(5)->get();

    // Carousel
    $carouselSlides = [
        ['title' => 'RC Drones', 'subtitle' => 'Explore the skies with our latest FPV & camera drones', 'cta' => 'Shop Drones', 'url' => route('shop.product_or_category.index', 'rc-drones'), 'gradient' => 'from-blue-600 to-indigo-800', 'emoji' => '🚁'],
        ['title' => 'RC Vehicles', 'subtitle' => 'High-speed cars, trucks & buggies for every terrain', 'cta' => 'Shop Vehicles', 'url' => route('shop.product_or_category.index', 'rc-vehicles'), 'gradient' => 'from-orange-500 to-red-600', 'emoji' => '🏎️'],
        ['title' => 'Musical Instruments', 'subtitle' => 'Guitars, keyboards & more at unbeatable prices', 'cta' => 'Shop Instruments', 'url' => route('shop.product_or_category.index', 'musical-instruments'), 'gradient' => 'from-purple-600 to-pink-600', 'emoji' => '🎸'],
    ];
@endphp

{{-- ====== TOP BANNER ====== --}}
<div class="bg-accent text-white text-center text-xs py-2 font-medium tracking-wide">
    🚚 FREE SHIPPING on orders over $50 &nbsp;|&nbsp; 🔄 30-Day Returns &nbsp;|&nbsp; 🔒 Secure Checkout
</div>

{{-- ====== HERO CAROUSEL ====== --}}
<div id="heroCarousel" class="relative overflow-hidden">
    <div id="heroSlides" class="flex transition-transform duration-500">
        @foreach($carouselSlides as $i => $slide)
            <div class="min-w-full bg-gradient-to-r {{ $slide['gradient'] }}">
                <div class="max-w-8xl mx-auto px-5 py-12 md:py-20 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 text-white text-center md:text-left">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">{{ $slide['title'] }}</h1>
                        <p class="text-lg text-white/80 mb-6 max-w-lg">{{ $slide['subtitle'] }}</p>
                        <a href="{{ $slide['url'] }}" class="inline-block bg-white text-gray-900 text-sm font-bold px-8 py-3 rounded-full hover:bg-gray-100 transition">{{ $slide['cta'] }}</a>
                    </div>
                    <div class="text-8xl md:text-[120px]">{{ $slide['emoji'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach($carouselSlides as $i => $s)
            <button onclick="goSlide({{ $i }})" class="w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white transition" id="dot-{{ $i }}"></button>
        @endforeach
    </div>
    <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white w-10 h-10 rounded-full flex items-center justify-center text-xl transition">‹</button>
    <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white w-10 h-10 rounded-full flex items-center justify-center text-xl transition">›</button>
</div>

{{-- ====== CATEGORY ICONS ====== --}}
<section class="max-w-8xl mx-auto px-5 py-10">
    <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
        @if(isset($categories))
            @foreach($categories as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat['slug']) }}" class="group flex flex-col items-center p-3 rounded-xl border border-gray-100 hover:border-accent hover:shadow-md transition-all no-underline">
                    <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center mb-2 text-lg group-hover:bg-accent group-hover:text-white transition">
                        @if($cat['slug'] == 'rc-drones') ✈️
                        @elseif($cat['slug'] == 'rc-vehicles') 🏎️
                        @elseif($cat['slug'] == 'rc-parts') 🔧
                        @elseif($cat['slug'] == 'rc-robot') 🤖
                        @elseif($cat['slug'] == 'musical-instruments') 🎸
                        @elseif($cat['slug'] == 'model-building-toys') 🧱
                        @elseif($cat['slug'] == 'learning-education') 📚
                        @elseif($cat['slug'] == 'dolls-stuffed-toys') 🧸
                        @elseif($cat['slug'] == 'baby-toddler-toys') 👶
                        @elseif($cat['slug'] == 'novelty-gagdet-toys') 🎮
                        @elseif($cat['slug'] == 'sports-outdoor') ⚽
                        @elseif($cat['slug'] == 'laptop-ac-adapters') 🔌
                        @else 🛒
                        @endif
                    </div>
                    <span class="text-[11px] font-medium text-gray-500 group-hover:text-accent transition text-center leading-tight">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        @endif
    </div>
</section>

{{-- ====== FLASH DEALS ====== --}}
@if($flashDeals->count())
<section class="max-w-8xl mx-auto px-5 pb-10">
    <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-2xl p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⚡</span>
                <h2 class="text-xl md:text-2xl font-bold text-white">Flash Deals</h2>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">Limited Time</span>
            </div>
            <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="text-white text-sm font-medium hover:underline">View All →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach($flashDeals as $product)
                <a href="{{ route('shop.product_or_category.index', $product->url_key ?? '#') }}" class="bg-white rounded-xl overflow-hidden hover:shadow-lg transition group no-underline">
                    <div class="aspect-square bg-gray-50 p-3">
                        @if($product->base_image_url ?? null)
                            <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform" loading="lazy">
                        @else
                            <div class="flex items-center justify-center h-full text-3xl text-gray-200">📦</div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="text-xs font-medium text-gray-800 line-clamp-2 leading-4 mb-2">{{ $product->name }}</h3>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-sm font-bold text-red-600">${{ number_format($product->special_price, 2) }}</span>
                            <span class="text-[11px] text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== CATEGORY PRODUCT BLOCKS ====== --}}
@foreach($categoryBlocks as $block)
<section class="max-w-8xl mx-auto px-5 pb-10">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <div class="w-1 h-6 bg-accent rounded-full"></div>
            <h2 class="text-xl font-bold text-gray-900">{{ $block['name'] }}</h2>
        </div>
        <a href="{{ route('shop.product_or_category.index', $block['slug']) }}" class="text-sm text-accent font-medium hover:underline">View All →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        @foreach($block['products'] as $product)
            <a href="{{ route('shop.product_or_category.index', $product->url_key ?? '#') }}" class="border border-gray-100 rounded-xl overflow-hidden hover:border-accent hover:shadow-md transition group no-underline">
                <div class="aspect-square bg-gray-50 p-3">
                    @if($product->base_image_url ?? null)
                        <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform" loading="lazy">
                    @else
                        <div class="flex items-center justify-center h-full text-3xl text-gray-200">📦</div>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="text-xs font-medium text-gray-800 line-clamp-2 leading-4 mb-1.5">{{ $product->name }}</h3>
                    <div class="flex items-baseline gap-1.5">
                        @if(($product->special_price ?? 0) > 0)
                            <span class="text-sm font-bold text-accent">${{ number_format($product->special_price, 2) }}</span>
                            <span class="text-[11px] text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endforeach

{{-- ====== CTA BANNER ====== --}}
<section class="max-w-8xl mx-auto px-5 pb-10">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-14 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">New Arrivals Every Week</h2>
        <p class="text-blue-200 mb-6 max-w-lg mx-auto">Stay updated with the latest RC products, drones & tech accessories.</p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="inline-block bg-white text-blue-700 text-sm font-bold px-8 py-3 rounded-full hover:bg-blue-50 transition">Browse All Products</a>
    </div>
</section>

{{-- ====== TRUST BADGES ====== --}}
<section class="max-w-8xl mx-auto px-5 pb-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <span class="text-2xl">🚚</span>
            <div><p class="text-sm font-semibold text-gray-900">Free Shipping</p><p class="text-xs text-gray-500">Orders over $50</p></div>
        </div>
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <span class="text-2xl">🔄</span>
            <div><p class="text-sm font-semibold text-gray-900">30-Day Returns</p><p class="text-xs text-gray-500">Hassle-free</p></div>
        </div>
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <span class="text-2xl">🔒</span>
            <div><p class="text-sm font-semibold text-gray-900">Secure Checkout</p><p class="text-xs text-gray-500">SSL encrypted</p></div>
        </div>
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <span class="text-2xl">💬</span>
            <div><p class="text-sm font-semibold text-gray-900">24/7 Support</p><p class="text-xs text-gray-500">Always here to help</p></div>
        </div>
    </div>
</section>

{{-- Carousel JS --}}
<script>
let currentSlide = 0;
const totalSlides = {{ count($carouselSlides) }};
function goSlide(n) {
    currentSlide = n;
    document.getElementById('heroSlides').style.transform = 'translateX(-' + (n * 100) + '%)';
    document.querySelectorAll('[id^="dot-"]').forEach(function(d, i) { d.style.background = i === n ? 'white' : 'rgba(255,255,255,0.5)'; });
}
function nextSlide() { goSlide((currentSlide + 1) % totalSlides); }
function prevSlide() { goSlide((currentSlide - 1 + totalSlides) % totalSlides); }
goSlide(0);
setInterval(nextSlide, 5000);
</script>

@endsection
