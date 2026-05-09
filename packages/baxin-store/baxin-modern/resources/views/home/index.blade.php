@extends('baxin-modern::layouts.master')
@section('title', 'Baxin Store — RC Toys & Kids')

@push('styles')
<style>
.carousel-slide { display: none; }
.carousel-slide.active { display: flex; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.carousel-dot { transition: all 0.3s; }
</style>
@endpush

@section('content')

{{-- ① TOPBAR --}}
<div class="bg-gray-900 text-white text-xs py-2 px-4 text-center">
    <span class="mr-6">🚚 Free shipping on orders over $49</span>
    <span class="mr-6">🔥 Flash deals updated daily</span>
    <span>📦 Easy 30-day returns</span>
</div>

{{-- ② CATEGORY NAV (sticky) --}}
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

{{-- ③ CATEGORY ICONS --}}
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

{{-- ④ HERO CAROUSEL --}}
<div class="max-w-7xl mx-auto px-4 mt-4 relative overflow-hidden rounded-xl" id="carousel">
    @foreach($carouselSlides as $i => $slide)
        <div class="carousel-slide {{ $i === 0 ? 'active' : '' }} flex-col md:flex-row items-center justify-between px-6 md:px-12 py-8 md:py-10 rounded-xl min-h-48 md:min-h-52 text-center md:text-left"
            style="background: {{ $slide['bg'] }};">
            <div class="max-w-md">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-2 md:mb-3">{{ $slide['title'] }}</h1>
                <p class="text-gray-500 mb-4 md:mb-6 text-sm md:text-base">{{ $slide['subtitle'] }}</p>
                <a href="{{ $slide['url'] }}"
                    class="inline-block bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-full hover:bg-blue-700 transition no-underline">
                    {{ $slide['cta'] }}
                </a>
            </div>
            @if($slide['image'])
                <img src="{{ $slide['image'] }}" class="h-28 md:h-40 object-contain mt-4 md:mt-0" alt="{{ $slide['title'] }}" />
            @else
                <div class="hidden md:flex w-40 h-40 bg-white/50 rounded-2xl items-center justify-center text-4xl">🎮</div>
            @endif
        </div>
    @endforeach

    {{-- Controls --}}
    <button onclick="prevSlide()"
        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">‹</button>
    <button onclick="nextSlide()"
        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">›</button>

    {{-- Dots --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5" id="carousel-dots">
        @foreach($carouselSlides as $i => $slide)
            <button onclick="goToSlide({{ $i }})"
                class="carousel-dot w-2 h-2 rounded-full transition {{ $i === 0 ? 'bg-blue-600 w-5' : 'bg-gray-300' }}">
            </button>
        @endforeach
    </div>
</div>

{{-- ⑤ PROMO BANNERS --}}
<div class="max-w-7xl mx-auto px-4 mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
    <a href="#" class="bg-blue-50 rounded-xl p-4 flex items-center gap-3 hover:bg-blue-100 transition no-underline">
        <span class="text-2xl">🚁</span>
        <div>
            <div class="text-sm font-medium text-blue-900">New Drones</div>
            <div class="text-xs text-blue-600">Up to 40% off</div>
        </div>
    </a>
    <a href="#" class="bg-orange-50 rounded-xl p-4 flex items-center gap-3 hover:bg-orange-100 transition no-underline">
        <span class="text-2xl">🤖</span>
        <div>
            <div class="text-sm font-medium text-orange-900">RC Robots</div>
            <div class="text-xs text-orange-600">Free shipping</div>
        </div>
    </a>
    <a href="#" class="bg-pink-50 rounded-xl p-4 flex items-center gap-3 hover:bg-pink-100 transition no-underline">
        <span class="text-2xl">🧸</span>
        <div>
            <div class="text-sm font-medium text-pink-900">Toys & Dolls</div>
            <div class="text-xs text-pink-600">Buy 2 get 1 free</div>
        </div>
    </a>
</div>

{{-- ⑥ FLASH DEALS --}}
@if($flashDeals->count())
<section id="flash-deals" class="max-w-7xl mx-auto px-4 py-8">
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

{{-- ⑦ CATEGORY PRODUCT BLOCKS --}}
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

{{-- ⑧ CTA BANNER --}}
<section class="max-w-7xl mx-auto px-4 pb-10">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">New Arrivals Every Week</h2>
        <p class="text-blue-200 mb-6 max-w-lg mx-auto">Stay updated with the latest RC products, drones & tech accessories.</p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="inline-block bg-white text-blue-700 text-sm font-bold px-8 py-3 rounded-full hover:bg-blue-50 transition no-underline">Browse All Products</a>
    </div>
</section>

{{-- ⑨ TRUST BADGES --}}
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
var currentSlide = 0;
var totalSlides = {{ count($carouselSlides) }};

function goToSlide(n) {
    currentSlide = n;
    var slides = document.querySelectorAll('.carousel-slide');
    var dots = document.querySelectorAll('.carousel-dot');
    for (var i = 0; i < slides.length; i++) {
        slides[i].classList.toggle('active', i === n);
        dots[i].className = 'carousel-dot w-2 h-2 rounded-full transition ' + (i === n ? 'bg-blue-600 w-5' : 'bg-gray-300');
    }
}
function nextSlide() { goToSlide((currentSlide + 1) % totalSlides); }
function prevSlide() { goToSlide((currentSlide - 1 + totalSlides) % totalSlides); }
setInterval(nextSlide, 5000);
</script>
@endpush

@endsection
