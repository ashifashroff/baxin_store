@extends('baxin-banggood::layouts.master')
@section('title', 'All Categories — Baxin Store')

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-8xl mx-auto px-4 py-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('shop.home.index') }}" class="hover:text-brand-600 transition no-underline">Home</a>
        <span>›</span>
        <span class="text-gray-900 font-medium">Categories</span>
    </nav>
</div>

<section class="max-w-8xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Shop by Category</h1>

    @php
        $allCategories = \Illuminate\Support\Facades\DB::table('categories')
            ->join('category_translations', function($j) { $j->on('categories.id', '=', 'category_translations.category_id')->where('category_translations.locale', 'en'); })
            ->where('categories.parent_id', 141)
            ->select('categories.id', 'categories.slug', 'category_translations.name', 'categories.image')
            ->orderBy('categories.position')
            ->get();
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($allCategories as $cat)
            @php
                $productCount = \Illuminate\Support\Facades\DB::table('product_categories')
                    ->where('category_id', $cat->id)
                    ->count();
            @endphp
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="group bg-white rounded-xl border border-gray-100 p-6 text-center hover:shadow-lg hover:-translate-y-1 transition-all no-underline">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">
                    @switch($cat->slug)
                        @case('rc-drones') 🚁 @break
                        @case('rc-robots') 🤖 @break
                        @case('rc-vehicles') 🏎️ @break
                        @case('dolls-stuffed-toys') 🧸 @break
                        @case('rc-parts') 🔧 @break
                        @default 🛍️
                    @endswitch
                </div>
                <h2 class="font-semibold text-gray-900 group-hover:text-brand-600 transition">{{ $cat->name }}</h2>
                <span class="text-xs text-gray-400 mt-1">{{ $productCount }} products</span>
            </a>
        @endforeach
    </div>
</section>

@endsection
