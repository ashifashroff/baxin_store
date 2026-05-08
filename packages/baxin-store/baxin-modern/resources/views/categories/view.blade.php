@extends('baxin-modern::layouts.master')

@section('title', ($category->name ?? 'Shop') . ' | Baxin Store')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('shop.home.index') }}" class="hover:text-gray-600 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700">{{ $category->name ?? 'Shop' }}</span>
    </nav>

    <div class="flex gap-8">
        {{-- Sidebar Filters --}}
        <aside class="hidden lg:block w-56 flex-shrink-0">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Filters</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Category</p>
                    @if(isset($category) && $category->parent_id == 141)
                        @foreach($category->parent->children->where('status', 1) as $sibling)
                            <a href="{{ route('shop.product_or_category.index', $sibling->slug) }}"
                                class="block text-sm py-1 {{ $sibling->id == $category->id ? 'text-accent font-medium' : 'text-gray-600 hover:text-gray-900' }} transition">
                                {{ $sibling->name }}
                            </a>
                        @endforeach
                    @else
                        @php
                            $shopCat = app('Webkul\Category\Repositories\CategoryRepository')->findOrFail(141);
                        @endphp
                        @foreach($shopCat->children->where('status', 1) as $child)
                            <a href="{{ route('shop.product_or_category.index', $child->slug) }}"
                                class="block text-sm py-1 {{ isset($category) && $child->id == $category->id ? 'text-accent font-medium' : 'text-gray-600 hover:text-gray-900' }} transition">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $category->name ?? 'Shop' }}</h1>
                <form method="GET" class="flex items-center gap-2">
                    <select name="sort" onchange="this.form.submit()"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 focus:outline-none focus:border-accent">
                        <option value="created_at,desc" {{ request('sort') == 'created_at,desc' ? 'selected' : '' }}>Newest</option>
                        <option value="created_at,asc" {{ request('sort') == 'created_at,asc' ? 'selected' : '' }}>Oldest</option>
                        <option value="price,asc" {{ request('sort') == 'price,asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price,desc" {{ request('sort') == 'price,desc' ? 'selected' : '' }}>Price: High → Low</option>
                    </select>
                </form>
            </div>

            {{-- Products via Bagisto's built-in product list component --}}
            <v-product-list category-id="{{ $category->id ?? 141 }}">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="animate-pulse" style="aspect-ratio:1/1.2" >
                        <div class="bg-gray-100 rounded-2xl h-full"></div>
                    </div>
                    <div class="animate-pulse" style="aspect-ratio:1/1.2">
                        <div class="bg-gray-100 rounded-2xl h-full"></div>
                    </div>
                    <div class="animate-pulse hidden md:block" style="aspect-ratio:1/1.2">
                        <div class="bg-gray-100 rounded-2xl h-full"></div>
                    </div>
                    <div class="animate-pulse hidden lg:block" style="aspect-ratio:1/1.2">
                        <div class="bg-gray-100 rounded-2xl h-full"></div>
                    </div>
                </div>
            </v-product-list>
        </div>
    </div>

</section>
@endsection
