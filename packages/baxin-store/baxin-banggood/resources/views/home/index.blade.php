@extends('baxin-banggood::layouts.master')
@section('title', 'Baxin Store — RC Toys, Drones, Robots & Gadgets')
@section('meta_description', 'Shop RC Drones, Robots, Vehicles & Parts at the best prices. Free shipping over $49. Flash deals daily.')

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .animate-marquee { animation: marquee 20s linear infinite; }
    @media (prefers-reduced-motion: reduce) { .animate-marquee { animation: none; } }
    .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%); }
    .flash-timer { font-variant-numeric: tabular-nums; }
</style>
@endpush

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section class="hero-gradient text-white">
    <div class="max-w-8xl mx-auto px-4 py-12 md:py-20">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-block bg-white/20 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">🔥 New Arrivals 2026</span>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">RC Toys &<br>Gadgets Store</h1>
                <p class="text-blue-100 text-lg mb-6 max-w-md">Explore our collection of RC drones, robots, vehicles & parts. Quality gear at unbeatable prices.</p>
                <div class="flex gap-3">
                    <a href="{{ route('shop.product_or_category.index', 'rc-drones') }}" class="bg-white text-brand-700 px-6 py-3 rounded-full font-semibold text-sm hover:bg-blue-50 transition no-underline">Shop Drones</a>
                    <a href="#flash-deals" class="border-2 border-white text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-white/10 transition no-underline">Flash Deals</a>
                </div>
            </div>
            <div class="hidden md:flex justify-center">
                <div class="text-9xl opacity-30">🚁</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CATEGORY QUICK LINKS ===== --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-8xl mx-auto px-4 py-6">
        <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
            @foreach($navCategories ?? [] as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-gray-50 hover:bg-brand-50 hover:shadow-md transition group no-underline">
                    <span class="text-3xl group-hover:scale-110 transition-transform">
                        @switch($cat->slug)
                            @case('rc-drones') 🚁 @break
                            @case('rc-robots') 🤖 @break
                            @case('rc-vehicles') 🏎️ @break
                            @case('dolls-stuffed-toys') 🧸 @break
                            @case('rc-parts') 🔧 @break
                            @default 🛍️
                        @endswitch
                    </span>
                    <span class="text-xs font-medium text-gray-700 group-hover:text-brand-600 transition text-center">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FLASH DEALS ===== --}}
@if($flashDeals->count() > 0)
<section id="flash-deals" class="bg-gray-50">
    <div class="max-w-8xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">⚡ Flash Deals</h2>
                <div class="flex items-center gap-1 bg-gray-900 text-white px-3 py-1.5 rounded-lg text-sm font-mono flash-timer">
                    <span id="flash-hours">08</span>:<span id="flash-mins">45</span>:<span id="flash-secs">30</span>
                </div>
            </div>
            <a href="#" class="text-brand-600 text-sm font-medium hover:underline no-underline">View All →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($flashDeals as $product)
                @include('baxin-banggood::components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CATEGORY BLOCKS ===== --}}
@foreach($categoryBlocks as $block)
    @if($block->products->count() > 0)
    <section class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
        <div class="max-w-8xl mx-auto px-4 py-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $block->name }}</h2>
                <a href="{{ route('shop.product_or_category.index', $block->slug) }}" class="text-brand-600 text-sm font-medium hover:underline no-underline">View All →</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($block->products as $product)
                    @include('baxin-banggood::components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

{{-- ===== PROMO BANNER ===== --}}
<section class="bg-brand-600 text-white">
    <div class="max-w-8xl mx-auto px-4 py-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Ready to Fly?</h2>
                <p class="text-blue-100 mb-5">Get the latest RC drones and vehicles delivered to your door. Free shipping on orders over $49.</p>
                <a href="{{ route('shop.product_or_category.index', 'rc-drones') }}" class="inline-block bg-white text-brand-700 px-8 py-3 rounded-full font-semibold text-sm hover:bg-blue-50 transition no-underline">Shop Now</a>
            </div>
            <div class="hidden md:flex justify-center">
                <div class="text-8xl opacity-30">✈️</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== NEW ARRIVALS (latest products) ===== --}}
<section class="bg-white">
    <div class="max-w-8xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900">🆕 New Arrivals</h2>
        </div>
        @php
            $newArrivals = \Illuminate\Support\Facades\DB::table('product_flat')
                ->join('product_images', 'product_flat.product_id', '=', 'product_images.product_id')
                ->join('product_categories', 'product_flat.product_id', '=', 'product_categories.product_id')
                ->join('categories', 'product_categories.category_id', '=', 'categories.id')
                ->join('category_translations', function($j) { $j->on('categories.id', '=', 'category_translations.category_id')->where('category_translations.locale', 'en'); })
                ->select('product_flat.product_id', 'product_flat.name', 'product_flat.url_key', 'product_flat.price', 'product_flat.special_price', 'product_images.path as image_path', 'category_translations.name as category_name')
                ->where('product_flat.channel', 'default')
                ->where('product_flat.locale', 'en')
                ->groupBy('product_flat.product_id', 'product_flat.name', 'product_flat.url_key', 'product_flat.price', 'product_flat.special_price', 'product_images.path', 'category_translations.name')
                ->orderByDesc('product_flat.product_id')
                ->limit(6)
                ->get();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($newArrivals as $product)
                @include('baxin-banggood::components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
// Flash deal countdown timer
(function() {
    var end = new Date();
    end.setHours(end.getHours() + 8);
    end.setMinutes(end.getMinutes() + 45);
    function update() {
        var now = new Date();
        var diff = Math.max(0, Math.floor((end - now) / 1000));
        var h = Math.floor(diff / 3600);
        var m = Math.floor((diff % 3600) / 60);
        var s = diff % 60;
        document.getElementById('flash-hours').textContent = String(h).padStart(2, '0');
        document.getElementById('flash-mins').textContent = String(m).padStart(2, '0');
        document.getElementById('flash-secs').textContent = String(s).padStart(2, '0');
    }
    update();
    setInterval(update, 1000);
})();
</script>
@endpush
@endsection
