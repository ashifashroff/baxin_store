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

    <button onclick="prevSlide()"
        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">‹</button>
    <button onclick="nextSlide()"
        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-8 h-8 flex items-center justify-center shadow text-gray-700">›</button>

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

{{-- ⑥ CATEGORY PRODUCT BLOCKS --}}
@foreach($categoryBlocks as $block)
<section id="{{ \Illuminate\Support\Str::slug($block['name']) }}" class="max-w-7xl mx-auto px-4 mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ $block['name'] }}</h2>
        <a href="/{{ $block['slug'] }}" class="text-sm text-blue-600 hover:underline no-underline">View all ›</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @foreach($block['products'] as $product)
            <a href="{{ route('shop.product_or_category.index', $product->url_key ?? '#') }}"
                class="bg-white border border-gray-100 rounded-xl p-3 hover:shadow-md hover:-translate-y-0.5 transition-all group no-underline">
                <div class="aspect-square bg-gray-50 rounded-lg mb-3 overflow-hidden">
                    @if($product->base_image_url ?? null)
                        <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform" loading="lazy" />
                    @else
                        <div class="flex items-center justify-center h-full text-3xl text-gray-200">📦</div>
                    @endif
                </div>
                <p class="text-xs text-gray-700 line-clamp-2 mb-2">{{ $product->name }}</p>
                <div class="flex items-center gap-1.5">
                    @if(($product->special_price ?? 0) > 0)
                        <span class="text-sm font-semibold text-red-500">${{ number_format($product->special_price, 2) }}</span>
                        <span class="text-xs text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</section>
@endforeach

{{-- ⑦ FLASH DEALS — 1 row × 5 columns --}}
@if($flashDeals->count())
<section id="flash-deals" class="max-w-7xl mx-auto px-4 mt-10">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-900">⚡️ Flash Deals</h2>
            <div class="bg-red-500 text-white text-xs font-medium px-3 py-1 rounded-full flex items-center gap-1">
                Ends in <span id="flash-countdown" class="font-mono ml-1">--:--:--</span>
            </div>
        </div>
        <a href="/special-offers" class="text-sm text-blue-600 hover:underline no-underline">View all ›</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @foreach($flashDeals as $product)
            @php
                $price = $product->price;
                $special = $product->special_price;
                $discount = $special ? round((($price - $special) / $price) * 100) : 0;
            @endphp
            <a href="{{ route('shop.product_or_category.index', $product->url_key ?? '#') }}"
                class="bg-white border border-gray-100 rounded-xl p-3 hover:shadow-md hover:-translate-y-0.5 transition-all group relative no-underline">
                @if($discount > 0)
                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                        -{{ $discount }}%
                    </div>
                @endif
                <div class="aspect-square bg-gray-50 rounded-lg mb-3 overflow-hidden">
                    @if($product->base_image_url ?? null)
                        <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform" loading="lazy" />
                    @else
                        <div class="flex items-center justify-center h-full text-3xl text-gray-200">📦</div>
                    @endif
                </div>
                <p class="text-xs text-gray-700 line-clamp-2 mb-2">{{ $product->name }}</p>
                <div class="flex items-center gap-1.5">
                    <span class="text-sm font-semibold text-red-500">${{ number_format($special, 2) }}</span>
                    <span class="text-xs text-gray-400 line-through">${{ number_format($price, 2) }}</span>
                </div>
                {{-- Progress bar --}}
                <div class="mt-2 bg-gray-100 rounded-full h-1.5">
                    <div class="bg-red-400 h-1.5 rounded-full" style="width: {{ rand(30, 85) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Almost gone</p>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ⑧ BOTTOM BANNERS --}}
<div class="max-w-7xl mx-auto px-4 mt-10 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <a href="#" class="bg-gradient-to-r from-blue-600 to-blue-400 rounded-2xl p-6 flex items-center justify-between text-white hover:opacity-90 transition no-underline">
        <div>
            <div class="text-lg font-semibold mb-1">RC Parts Clearance</div>
            <div class="text-sm text-blue-100">Up to 60% off genuine parts</div>
            <div class="mt-3 inline-block bg-white text-blue-600 text-xs font-medium px-4 py-1.5 rounded-full">Shop Now</div>
        </div>
        <span class="text-5xl">🔧</span>
    </a>
    <a href="#" class="bg-gradient-to-r from-pink-500 to-rose-400 rounded-2xl p-6 flex items-center justify-between text-white hover:opacity-90 transition no-underline">
        <div>
            <div class="text-lg font-semibold mb-1">Kids' Favourites</div>
            <div class="text-sm text-pink-100">Dolls, plushies & more</div>
            <div class="mt-3 inline-block bg-white text-pink-600 text-xs font-medium px-4 py-1.5 rounded-full">Explore</div>
        </div>
        <span class="text-5xl">🧸</span>
    </a>
</div>

{{-- ⑨ FOOTER --}}
<footer class="bg-gray-50 border-t border-gray-100 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 mb-10">
            <div>
                <div class="text-base font-semibold text-gray-900 mb-4">Baxin Store</div>
                <p class="text-sm text-gray-500 leading-relaxed">Your one-stop shop for RC toys, drones, robots and kids' favourites.</p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-100 transition text-xs no-underline">f</a>
                    <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-pink-100 transition text-xs no-underline">ig</a>
                    <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-red-100 transition text-xs no-underline">yt</a>
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-900 mb-4">Shop</div>
                <ul class="space-y-2 text-sm text-gray-500 list-none p-0 m-0">
                    @foreach(['RC Drones','RC Robot','RC Vehicles','Dolls & Stuffed Toys','RC Parts'] as $cat)
                        <li><a href="#" class="hover:text-gray-900 transition no-underline">{{ $cat }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-900 mb-4">Support</div>
                <ul class="space-y-2 text-sm text-gray-500 list-none p-0 m-0">
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Help Center</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Track Order</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Returns</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-900 mb-4">We Accept</div>
                <div class="flex flex-wrap gap-2">
                    @foreach(['PayPal','Stripe','Razorpay','PayU'] as $pay)
                        <span class="bg-white border border-gray-200 text-xs text-gray-600 px-2 py-1 rounded">{{ $pay }}</span>
                    @endforeach
                </div>
                <div class="text-sm font-semibold text-gray-900 mt-6 mb-3">Legal</div>
                <ul class="space-y-2 text-sm text-gray-500 list-none p-0 m-0">
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition no-underline">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 pt-6 text-sm text-gray-400 text-center">
            © {{ date('Y') }} Baxin Store — Mirai Global Solutions. All rights reserved.
        </div>
    </div>
</footer>

@endsection

@push('scripts')
<script>
// ── Carousel ──────────────────────────────────────────────
let current = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');

function goToSlide(n) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('bg-blue-600', 'w-5');
    dots[current].classList.add('bg-gray-300');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('bg-blue-600', 'w-5');
    dots[current].classList.remove('bg-gray-300');
}
function nextSlide() { goToSlide(current + 1); }
function prevSlide() { goToSlide(current - 1); }
setInterval(nextSlide, 5000);

// ── Flash Deals Countdown ─────────────────────────────────
function updateCountdown() {
    const el = document.getElementById('flash-countdown');
    if (!el) return;
    const now = new Date();
    const end = new Date();
    end.setHours(23, 59, 59, 0);
    let diff = Math.max(0, Math.floor((end - now) / 1000));
    const h = String(Math.floor(diff / 3600)).padStart(2, '0');
    diff %= 3600;
    const m = String(Math.floor(diff / 60)).padStart(2, '0');
    const s = String(diff % 60).padStart(2, '0');
    el.textContent = h + ':' + m + ':' + s;
}
updateCountdown();
setInterval(updateCountdown, 1000);
</script>
@endpush
