@extends('baxin-modern::layouts.master')
@section('title', ($category->name ?? 'Categories') . ' — Baxin Store')

@php
    $categoryId = $category->id ?? null;
    $sort = request('sort', 'newest');
    $limit = (int) request('limit', 20);
    $page = (int) request('page', 1);

    // Fetch products via API-style query
    $query = \Webkul\Product\Models\ProductFlat::query()
        ->join('product_categories', 'product_flat.id', '=', 'product_categories.product_id')
        ->where('product_categories.category_id', $categoryId)
        ->where('product_flat.locale', app()->getLocale())
        ->where('product_flat.status', 1)
        ->select('product_flat.id', 'product_flat.name', 'product_flat.url_key', 'product_flat.price', 'product_flat.special_price', 'product_flat.created_at');

    // Sort
    switch ($sort) {
        case 'price_asc':  $query->orderBy('product_flat.price', 'asc'); break;
        case 'price_desc': $query->orderBy('product_flat.price', 'desc'); break;
        default:           $query->orderBy('product_flat.created_at', 'desc'); break;
    }

    $products = $query->paginate($limit, ['*'], 'page', $page);

    // Attach image URLs
    $products->each(function ($p) {
        $path = \Illuminate\Support\Facades\DB::table('product_images')
            ->where('product_id', $p->id)
            ->orderBy('id')
            ->value('path');
        $p->image_url = $path ? 'https://baxin.store/cache/medium/' . $path : '';
    });
@endphp

@push('styles')
<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
input[type=range]::-webkit-slider-thumb { appearance: none; width: 16px; height: 16px; border-radius: 50%; background: #2563EB; cursor: pointer; }
input[type=range]::-webkit-slider-runnable-track { height: 4px; background: #E5E7EB; border-radius: 2px; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-7xl mx-auto px-4 py-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('shop.home.index') }}" class="hover:text-blue-600 transition no-underline">Home</a>
        <span>›</span>
        @if(isset($category) && $category->parent)
            <a href="{{ route('shop.product_or_category.index', $category->parent->slug) }}" class="hover:text-blue-600 transition no-underline">{{ $category->parent->name }}</a>
            <span>›</span>
        @endif
        <span class="text-gray-900 font-medium">{{ $category->name ?? 'Categories' }}</span>
    </nav>
</div>

<div class="max-w-7xl mx-auto px-4 pb-16 flex gap-6">

    {{-- SIDEBAR FILTERS --}}
    <aside class="hidden lg:block w-56 shrink-0">
        <form method="GET" id="filter-form">

            {{-- Price Range --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Price Range</h3>
                <input type="range" name="price_to" id="price-range"
                    min="0" max="500" value="{{ request('price_to', 500) }}"
                    class="w-full" oninput="document.getElementById('price-val').textContent = this.value" />
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>$0</span>
                    <span>Up to $<span id="price-val">{{ request('price_to', 500) }}</span></span>
                </div>
            </div>

            {{-- Sort --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Sort By</h3>
                @foreach([
                    'newest' => 'Newest First',
                    'price_asc' => 'Price: Low to High',
                    'price_desc' => 'Price: High to Low',
                ] as $val => $label)
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="radio" name="sort" value="{{ $val }}"
                            {{ $sort === $val ? 'checked' : '' }}
                            class="accent-blue-600" />
                        <span class="text-sm text-gray-600">{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Subcategories --}}
            @if(isset($category) && $category->children->count())
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Subcategories</h3>
                    @foreach($category->children->where('status', 1) as $child)
                        <a href="{{ route('shop.product_or_category.index', $child->slug) }}" class="block text-sm text-gray-600 mb-2 hover:text-blue-600 transition no-underline">{{ $child->name }}</a>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="w-full bg-blue-600 text-white text-sm font-medium py-2.5 rounded-full hover:bg-blue-700 transition">Apply Filters</button>
            <a href="{{ request()->url() }}" class="block text-center text-xs text-gray-400 mt-2 hover:text-gray-600 no-underline">Clear all</a>
        </form>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 min-w-0">

        {{-- Header row --}}
        <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ $category->name ?? 'Categories' }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $products->total() }} products</p>
            </div>
            {{-- Mobile sort --}}
            <select onchange="window.location.href='?sort='+this.value"
                class="lg:hidden text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option value="newest" {{ $sort==='newest'?'selected':'' }}>Newest</option>
                <option value="price_asc" {{ $sort==='price_asc'?'selected':'' }}>Price ↑</option>
                <option value="price_desc" {{ $sort==='price_desc'?'selected':'' }}>Price ↓</option>
            </select>
        </div>

        {{-- Product Grid --}}
        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($products as $product)
                    @include('baxin-modern::components.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasMorePages())
                <div class="flex justify-center mt-8">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <p class="text-4xl mb-3">📦</p>
                <p class="text-gray-500">No products found in this category.</p>
                <a href="{{ route('shop.home.index') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline no-underline">Back to Home</a>
            </div>
        @endif
    </div>
</div>

@endsection
