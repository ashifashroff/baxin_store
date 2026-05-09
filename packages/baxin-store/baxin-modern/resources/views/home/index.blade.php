@extends('baxin-modern::layouts.master')
@section('title', 'Baxin Store — RC Toys & Kids')

@push('styles')
<style>
.carousel-slide { display: none; }
.carousel-slide.active { display: flex; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')

{{-- ① TOPBAR --}}
<div class="bg-gray-900 text-white text-xs py-2 px-4 text-center">
    <span class="mr-6">🚚 Free shipping on orders over $49</span>
    <span class="mr-6">🔥 Flash deals updated daily</span>
    <span>📦 Easy 30-day returns</span>
</div>

{{-- ② HERO CAROUSEL --}}
<section class="border-b border-gray-100">
    <div class="max-w-7xl mx-auto relative" id="carousel">
        @foreach($carouselSlides as $i => $slide)
            <div class="carousel-slide {{ $i === 0 ? 'active' : '' }} items-center py-10 md:py-16 px-6 md:px-12 rounded-2xl mx-4 my-6" style="background: {{ $slide['bg'] }}">
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $slide['title'] }}</h2>
                    <p class="text-gray-600 mb-6 text-lg">{{ $slide['subtitle'] }}</p>
                    <a href="{{ $slide['url'] }}" class="inline-block bg-accent text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-accent-hover transition">{{ $slide['cta'] }}</a>
                </div>
                @if($slide['image'])
                    <div class="hidden md:block flex-1 text-center">
                        <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="max-h-64 mx-auto">
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Dots --}}
        <div class="flex justify-center gap-2 pb-4">
            @foreach($carouselSlides as $i => $s)
                <button onclick="showSlide({{ $i }})" class="w-2.5 h-2.5 rounded-full {{ $i === 0 ? 'bg-accent' : 'bg-gray-300' }} transition" id="dot-{{ $i }}"></button>
            @endforeach
        </div>
    </div>
</section>

{{-- ③ CATEGORY NAV --}}
<div class="bg-white border-b border-gray-100 sticky top-[60px] z-40">
    <div class="max-w-7xl mx-auto px-4 flex items-center gap-6 overflow-x-auto no-scrollbar py-2">
        <button class="flex items-center gap-1 text-sm font-medium whitespace-nowrap hover:text-blue-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            All Categories
        </button>
        <span class="text-gray-200">|</span>
        @foreach(['RC Drones','RC Robot','RC Vehicles','Dolls & Stuffed Toys','RC Parts','Flash Deals','New Arrivals'] as $cat)
            <a href="#{{ \Illuminate\Support\Str::slug($cat) }}" class="text-sm text-gray-600 whitespace-nowrap hover:text-blue-600 transition no-underline">{{ $cat }}</a>
        @endforeach
    </div>
</div>

{{-- ④ CATEGORY ICONS --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
        @php
            $iconCats = app('Webkul\Category\Repositories\CategoryRepository')
                ->findOrFail(141)->children()->where('status', 1)->get();
        @endphp
        @foreach($iconCats as $cat)
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="group flex flex-col items-center p-3 rounded-xl border border-gray-100 hover:border-accent hover:shadow-md transition-all no-underline">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-2 text-xl group-hover:bg-accent group-hover:text-white transition">
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
                <span class="text-[11px] font-medium text-gray-500 group-hover:text-accent transition text-center leading-tight">{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>
</section>

{{-- ⑤ FLASH DEALS --}}
@if($flashDeals->count())
<section id="flash-deals" class="max-w-7xl mx-auto px-4 pb-10">
    <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-2xl p-5 md:p-7">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⚡</span>
                <h2 class="text-xl font-bold text-white">Flash Deals</h2>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">Limited Time</span>
            </div>
            <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="text-white text-sm font-medium hover:underline no-underline">View All →</a>
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

{{-- ⑥ CATEGORY PRODUCT BLOCKS --}}
@foreach($categoryBlocks as $block)
<section id="{{ \Illuminate\Support\Str::slug($block['name']) }}" class="max-w-7xl mx-auto px-4 pb-10">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <div class="w-1 h-6 bg-accent rounded-full"></div>
            <h2 class="text-xl font-bold text-gray-900">{{ $block['name'] }}</h2>
        </div>
        <a href="{{ route('shop.product_or_category.index', $block['slug']) }}" class="text-sm text-accent font-medium hover:underline no-underline">View All →</a>
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

{{-- ⑦ CTA BANNER --}}
<section class="max-w-7xl mx-auto px-4 pb-10">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">New Arrivals Every Week</h2>
        <p class="text-blue-200 mb-6 max-w-lg mx-auto">Stay updated with the latest RC products, drones & tech accessories.</p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="inline-block bg-white text-blue-700 text-sm font-bold px-8 py-3 rounded-full hover:bg-blue-50 transition no-underline">Browse All Products</a>
    </div>
</section>

{{-- ⑧ TRUST BADGES --}}
<section class="max-w-7xl mx-auto px-4 pb-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <span class="text-2xl">🚚</span>
            <div><p class="text-sm font-semibold text-gray-900">Free Shipping</p><p class="text-xs text-gray-500">Orders over $49</p></div>
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
@push('scripts')
<script>
function showSlide(n) {
    document.querySelectorAll('.carousel-slide').forEach(function(el, i) {
        el.classList.toggle('active', i === n);
    });
    document.querySelectorAll('[id^="dot-"]').forEach(function(el, i) {
        el.style.background = i === n ? '#2563EB' : '#d1d5db';
    });
}
var currentSlide = 0;
var totalSlides = {{ count($carouselSlides) }};
setInterval(function() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}, 5000);
</script>
@endpush

@endsection
