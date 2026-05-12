@extends('baxin-banggood::layouts.master')
@section('title', ($categoryName ?? 'Categories') . ' — Baxin Store')

@push('styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .filter-checkbox:checked + label { color: #2563eb; font-weight: 600; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-8xl mx-auto px-4 py-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
        <a href="{{ route('shop.home.index') }}" class="hover:text-brand-600 transition no-underline">Home</a>
        <span>›</span>
        <span class="text-gray-900 font-medium">{{ $categoryName ?? 'Categories' }}</span>
    </nav>
</div>

<section class="max-w-8xl mx-auto px-4 py-6">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar filters (desktop) --}}
        <aside class="hidden lg:block w-56 flex-shrink-0">
            <div class="sticky top-24">
                <h3 class="font-semibold text-gray-900 mb-4">Categories</h3>
                @if(isset($childCategories) && $childCategories->count())
                    <div class="space-y-1 mb-6">
                        @foreach($childCategories as $child)
                            <a href="{{ route('shop.product_or_category.index', $child->slug ?? '#') }}" class="block text-sm text-gray-600 hover:text-brand-600 py-1.5 no-underline">{{ $child->name ?? '' }}</a>
                        @endforeach
                    </div>
                @endif

                <h3 class="font-semibold text-gray-900 mb-3">Price Range</h3>
                <div class="space-y-2">
                    <a href="{{ request()->fullUrlWithQuery(['price' => '0-25']) }}" class="block text-sm text-gray-600 hover:text-brand-600 py-1 no-underline">Under $25</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '25-50']) }}" class="block text-sm text-gray-600 hover:text-brand-600 py-1 no-underline">$25 – $50</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '50-100']) }}" class="block text-sm text-gray-600 hover:text-brand-600 py-1 no-underline">$50 – $100</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '100-']) }}" class="block text-sm text-gray-600 hover:text-brand-600 py-1 no-underline">$100+</a>
                </div>
            </div>
        </aside>

        {{-- Product grid --}}
        <div class="flex-1">
            {{-- Header: title, count, sort --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $categoryName ?? 'All Products' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ ($products->total() ?? count($products)) }} products</p>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Mobile filter toggle --}}
                    <button class="lg:hidden flex items-center gap-1 text-sm text-gray-600 border border-gray-200 rounded-lg px-3 py-2" onclick="document.getElementById('mobile-filters').classList.toggle('hidden')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter
                    </button>
                    <select onchange="window.location.href=this.value" class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-brand-500">
                        <option value="{{ request()->url() }}?sort=newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="{{ request()->url() }}?sort=price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="{{ request()->url() }}?sort=price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="{{ request()->url() }}?sort=popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>
            </div>

            {{-- Mobile filters (hidden by default) --}}
            <div id="mobile-filters" class="hidden lg:hidden mb-4 p-4 bg-gray-50 rounded-xl space-y-3">
                <h3 class="font-semibold text-gray-900 text-sm">Price Range</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ request()->fullUrlWithQuery(['price' => '0-25']) }}" class="text-xs bg-white border border-gray-200 rounded-full px-3 py-1.5 no-underline hover:border-brand-500">Under $25</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '25-50']) }}" class="text-xs bg-white border border-gray-200 rounded-full px-3 py-1.5 no-underline hover:border-brand-500">$25 – $50</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '50-100']) }}" class="text-xs bg-white border border-gray-200 rounded-full px-3 py-1.5 no-underline hover:border-brand-500">$50 – $100</a>
                    <a href="{{ request()->fullUrlWithQuery(['price' => '100-']) }}" class="text-xs bg-white border border-gray-200 rounded-full px-3 py-1.5 no-underline hover:border-brand-500">$100+</a>
                </div>
            </div>

            {{-- Products grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                    @include('baxin-banggood::components.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($products, 'links'))
                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
