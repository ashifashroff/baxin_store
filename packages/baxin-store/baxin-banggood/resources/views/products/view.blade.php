@extends('baxin-banggood::layouts.master')
@section('title', ($product->name ?? 'Product') . ' — Baxin Store')

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .thumb-btn { border: 2px solid transparent; transition: border-color 0.15s; }
    .thumb-btn.active, .thumb-btn:hover { border-color: #2563eb; }
    .zoom-lens { cursor: zoom-in; }
</style>
@endpush

@section('content')

@php
    $productId = $product->id ?? 0;
    $allImages = \Illuminate\Support\Facades\DB::table('product_images')->where('product_id', $productId)->orderBy('id')->get();
    $mainImage = $allImages->first();
    $mainImageUrl = $mainImage ? 'https://baxin.store/cache/large/' . $mainImage->path : null;

    // Category for breadcrumb
    $category = null;
    if (isset($product) && method_exists($product, 'categories')) {
        $category = $product->categories->first();
    } elseif ($productId) {
        $catData = \Illuminate\Support\Facades\DB::table('product_categories')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->join('category_translations', function($j) { $j->on('categories.id', '=', 'category_translations.category_id')->where('category_translations.locale', 'en'); })
            ->where('product_categories.product_id', $productId)
            ->select('categories.slug', 'category_translations.name')
            ->first();
        $category = $catData;
    }
@endphp

{{-- Breadcrumb --}}
<div class="max-w-8xl mx-auto px-4 py-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('shop.home.index') }}" class="hover:text-brand-600 transition no-underline">Home</a>
        <span>›</span>
        @if($category)
            <a href="{{ route('shop.product_or_category.index', $category->slug) }}" class="hover:text-brand-600 transition no-underline">{{ $category->name }}</a>
            <span>›</span>
        @endif
        <span class="text-gray-900 font-medium truncate max-w-xs">{{ $product->name ?? 'Product' }}</span>
    </nav>
</div>

{{-- Product section --}}
<section class="max-w-8xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- ===== LEFT: Images ===== --}}
        <div>
            {{-- Main image --}}
            <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 mb-3 zoom-lens" id="main-image-container">
                @if($mainImageUrl)
                    <img id="main-product-img" src="{{ $mainImageUrl }}" alt="{{ $product->name ?? '' }}" class="w-full h-full object-contain p-8">
                @else
                    <div class="flex items-center justify-center h-full text-6xl text-gray-200">📦</div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($allImages->count() > 1)
                <div class="flex gap-2 overflow-x-auto pb-2">
                    @foreach($allImages as $img)
                        @php $thumbUrl = 'https://baxin.store/cache/small/' . $img->path; @endphp
                        @php $largeUrl = 'https://baxin.store/cache/large/' . $img->path; @endphp
                        <button onclick="document.getElementById('main-product-img').src='{{ $largeUrl }}'; document.querySelectorAll('.thumb-btn').forEach(b=>b.classList.remove('active')); this.classList.add('active');"
                            class="thumb-btn {{ $loop->first ? 'active' : '' }} flex-shrink-0 w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 cursor-pointer p-1">
                            <img src="{{ $thumbUrl }}" class="w-full h-full object-contain" loading="lazy" alt="Thumbnail">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ===== RIGHT: Product info ===== --}}
        <div>
            {{-- Title --}}
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $product->name ?? '' }}</h1>

            {{-- Rating placeholder --}}
            <div class="flex items-center gap-2 mb-4">
                <div class="flex text-yellow-400 text-sm">★★★★☆</div>
                <span class="text-xs text-gray-400">(reviews coming soon)</span>
            </div>

            {{-- Price --}}
            @php
                $price = (float) ($product->price ?? 0);
                $specialPrice = (float) ($product->special_price ?? 0);
                $hasDiscount = $specialPrice > 0 && $specialPrice < $price;
                $discount = $hasDiscount ? round(($price - $specialPrice) / $price * 100) : 0;
            @endphp
            <div class="flex items-baseline gap-3 mb-6 pb-6 border-b border-gray-100">
                @if($hasDiscount)
                    <span class="text-3xl font-bold text-brand-600">${{ number_format($specialPrice, 2) }}</span>
                    <span class="text-lg text-gray-400 line-through">${{ number_format($price, 2) }}</span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">-{{ $discount }}% OFF</span>
                @else
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($price, 2) }}</span>
                @endif
            </div>

            {{-- Short description --}}
            @if($product->short_description ?? null)
                <div class="text-sm text-gray-600 leading-relaxed mb-6">{!! $product->short_description !!}</div>
            @endif

            {{-- Quantity + Add to Cart --}}
            <div class="mb-8 space-y-4">
                <div class="flex items-center gap-4">
                    <label class="text-sm font-medium text-gray-700">Qty:</label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition text-lg">−</button>
                        <input type="number" id="qty" value="1" min="1" class="w-14 h-10 text-center border-x border-gray-200 text-sm focus:outline-none font-medium">
                        <button type="button" onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition text-lg">+</button>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="addToCart({{ $productId }})" class="flex-1 bg-brand-600 text-white font-semibold py-3.5 rounded-full hover:bg-brand-700 transition text-sm">
                        🛒 Add to Cart
                    </button>
                    <button onclick="toggleWishlist({{ $productId }})" class="w-12 h-12 border border-gray-200 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-200 transition" aria-label="Add to wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Trust badges --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-3">
                    <span class="text-lg">🚚</span>
                    <span class="text-xs text-gray-600">Free shipping over $49</span>
                </div>
                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-3">
                    <span class="text-lg">↩️</span>
                    <span class="text-xs text-gray-600">30-day returns</span>
                </div>
                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-3">
                    <span class="text-lg">🔒</span>
                    <span class="text-xs text-gray-600">Secure checkout</span>
                </div>
                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-3">
                    <span class="text-lg">📦</span>
                    <span class="text-xs text-gray-600">In stock</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($product->description ?? null)
        <div class="mt-12 border-t border-gray-100 pt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Product Description</h2>
            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">{!! $product->description !!}</div>
        </div>
    @endif
</section>

@push('scripts')
<script>
function changeQty(delta) {
    var el = document.getElementById('qty');
    el.value = Math.max(1, parseInt(el.value) + delta);
}
</script>
@endpush
@endsection
