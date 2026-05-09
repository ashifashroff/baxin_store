@extends('baxin-modern::layouts.master')
@section('title', ($category->name ?? 'Categories') . ' — Baxin Store')

@push('styles')
<style>
.product-card:hover .product-img { transform: scale(1.05); }
.product-img { transition: transform 0.3s ease; }
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
                    'popular' => 'Most Popular',
                ] as $val => $label)
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="radio" name="sort" value="{{ $val }}"
                            {{ request('sort', 'newest') === $val ? 'checked' : '' }}
                            class="accent-blue-600" />
                        <span class="text-sm text-gray-600">{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Availability --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Availability</h3>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="in_stock" value="1"
                        {{ request('in_stock') ? 'checked' : '' }}
                        class="accent-blue-600 rounded" />
                    <span class="text-sm text-gray-600">In Stock Only</span>
                </label>
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
            </div>
            {{-- Mobile sort --}}
            <select name="sort" onchange="window.location.href='?sort='+this.value"
                class="lg:hidden text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option value="newest" {{ request('sort','newest')==='newest'?'selected':'' }}>Newest</option>
                <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Price ↑</option>
                <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Price ↓</option>
            </select>
        </div>

        {{-- Bagisto Product Grid (Vue component) --}}
        <v-product-list category-id="{{ $category->id ?? 141 }}">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
                <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
                <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden sm:block"></div>
                <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden lg:block"></div>
            </div>
        </v-product-list>
    </div>
</div>

@endsection
