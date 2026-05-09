@extends('baxin-modern::layouts.master')
@section('title', ($product->name ?? 'Product') . ' — Baxin Store')

@push('styles')
<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.thumb-img { border: 2px solid transparent; transition: border-color 0.15s; }
.thumb-img.active, .thumb-img:hover { border-color: #2563EB; }
</style>
@endpush

@section('content')

@php
    $imageUrl = '';
    $path = DB::table('product_images')->where('product_id', $product->id ?? 0)->orderBy('id')->value('path');
    if ($path) $imageUrl = 'https://baxin.store/cache/medium/' . $path;
    
    $allImages = DB::table('product_images')->where('product_id', $product->id ?? 0)->orderBy('id')->get();
@endphp

{{-- Breadcrumb --}}
<div class="max-w-7xl mx-auto px-4 py-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('shop.home.index') }}" class="hover:text-blue-600 transition no-underline">Home</a>
        <span>›</span>
        @if(isset($product) && $product->categories->count())
            @php $cat = $product->categories->first(); @endphp
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="hover:text-blue-600 transition no-underline">{{ $cat->name }}</a>
            <span>›</span>
        @endif
        <span class="text-gray-900 font-medium truncate max-w-xs">{{ $product->name ?? 'Product' }}</span>
    </nav>
</div>

<section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- IMAGES --}}
        <div>
            {{-- Main Image --}}
            <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 mb-3">
                @if($imageUrl)
                    <img id="main-product-img" src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-8">
                @else
                    <div class="flex items-center justify-center h-full text-5xl text-gray-200">📦</div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($allImages->count() > 1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($allImages as $img)
                        @php $thumbUrl = 'https://baxin.store/cache/medium/' . $img->path; @endphp
                        <button onclick="document.getElementById('main-product-img').src='{{ $thumbUrl }}'" 
                            class="thumb-img {{ $loop->first ? 'active' : '' }} aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-100 cursor-pointer p-2">
                            <img src="{{ $thumbUrl }}" class="w-full h-full object-contain" loading="lazy">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- PRODUCT INFO --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name ?? '' }}</h1>

            {{-- Price --}}
            <div class="flex items-baseline gap-3 mb-6">
                @if(($product->special_price ?? 0) > 0)
                    <span class="text-3xl font-bold text-blue-600">${{ number_format($product->special_price, 2) }}</span>
                    <span class="text-lg text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                    @php $discount = round((($product->price - $product->special_price) / $product->price * 100)); @endphp
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">-{{ $discount }}%</span>
                @else
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price ?? 0, 2) }}</span>
                @endif
            </div>

            {{-- Short Description --}}
            @if($product->short_description ?? null)
                <div class="text-sm text-gray-600 leading-relaxed mb-6 border-t border-gray-100 pt-4">{!! $product->short_description !!}</div>
            @endif

            {{-- Add to Cart --}}
            <div class="mb-8 space-y-3">
                <div class="flex items-center gap-3">
                    <label class="text-sm text-gray-600">Qty:</label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" onclick="changeQty(-1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50 transition">−</button>
                        <input type="number" id="qty" value="1" min="1" class="w-12 text-center border-x border-gray-200 py-2 text-sm focus:outline-none">
                        <button type="button" onclick="changeQty(1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50 transition">+</button>
                    </div>
                </div>
                <button onclick="addToCart({{ $product->id ?? 0 }})" class="w-full bg-blue-600 text-white text-sm font-semibold py-3.5 rounded-full hover:bg-blue-700 transition">Add to Cart</button>
            </div>

            {{-- Trust --}}
            <div class="border-t border-gray-100 pt-6 grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2 text-sm text-gray-500"><span>🚚</span> Free shipping over $49</div>
                <div class="flex items-center gap-2 text-sm text-gray-500"><span>↩️</span> 30-day returns</div>
                <div class="flex items-center gap-2 text-sm text-gray-500"><span>🔒</span> Secure checkout</div>
                <div class="flex items-center gap-2 text-sm text-gray-500"><span>📦</span> In stock</div>
            </div>
        </div>
    </div>

    {{-- Description Tab --}}
    @if($product->description ?? null)
        <div class="mt-12 border-t border-gray-100 pt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
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
function addToCart(productId) {
    var qty = document.getElementById('qty').value;
    fetch('/api/checkout/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
        },
        body: JSON.stringify({ product_id: productId, quantity: qty })
    }).then(function(r) { return r.json(); }).then(function(data) {
        if(data.message) alert(data.message);
        else window.location.href = '/checkout/cart';
    }).catch(function() { alert('Error adding to cart'); });
}
</script>
@endpush
@endsection
