@extends('baxin-modern::layouts.master')

@section('title', 'Baxin Store — Modern Electronics & Tech')

@section('content')

    {{-- Hero --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
        <p class="text-sm font-medium text-accent tracking-widest uppercase mb-4">New Arrivals</p>
        <h1 class="text-4xl md:text-5xl font-semibold text-gray-900 leading-tight mb-6">
            Technology that<br class="hidden md:block"/> fits your life.
        </h1>
        <p class="text-lg text-gray-500 max-w-xl mx-auto mb-10">
            Discover the latest in RC, electronics, gadgets, and tech essentials — curated for modern living.
        </p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}"
            class="inline-block bg-accent text-white text-sm font-medium px-8 py-3 rounded-full hover:bg-blue-700 transition">
            Shop Now
        </a>
    </section>

    {{-- Category Grid --}}
    @if(isset($categories) && count($categories))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">Shop by Category</h2>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat['slug']) }}"
                    class="group flex flex-col items-center p-4 rounded-2xl border border-gray-100 hover:border-accent hover:shadow-md transition-all">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-3 group-hover:bg-accent group-hover:text-white transition text-xl">
                        @if($cat['slug'] == 'rc-drones') ✈️
                        @elseif($cat['slug'] == 'rc-vehicles') 🏎️
                        @elseif($cat['slug'] == 'rc-parts') 🔧
                        @elseif($cat['slug'] == 'rc-robot') 🤖
                        @elseif($cat['slug'] == 'musical-instruments') 🎸
                        @elseif($cat['slug'] == 'model-building-toys') 🧱
                        @elseif($cat['slug'] == 'learning-education') 📚
                        @elseif($cat['slug'] == 'dolls-stuffed-toys') 🧸
                        @elseif($cat['slug'] == 'baby-toddler-toys') 👶
                        @elseif($cat['slug'] == 'novelty-gagdet-toys') 🎮
                        @elseif($cat['slug'] == 'sports-outdoor') ⚽
                        @elseif($cat['slug'] == 'laptop-ac-adapters') 🔌
                        @else 🛒
                        @endif
                    </div>
                    <span class="text-xs font-medium text-gray-600 group-hover:text-accent transition text-center">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- CTA Banner --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-8 md:p-12 text-center text-white">
            <h2 class="text-2xl md:text-3xl font-semibold mb-3">Free shipping on orders over $50</h2>
            <p class="text-blue-100 mb-6">Shop our entire collection with confidence.</p>
            <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="inline-block bg-white text-blue-700 text-sm font-semibold px-8 py-3 rounded-full hover:bg-blue-50 transition">Start Shopping</a>
        </div>
    </section>

@endsection
