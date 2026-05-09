@extends('baxin-modern::layouts.master')

@section('title', 'Baxin Store — Modern Electronics & Tech')

@section('content')

    {{-- Hero --}}
    <section class="max-w-8xl mx-auto px-5 py-16 md:py-24 text-center">
        <p class="text-xs font-semibold text-accent tracking-[0.2em] uppercase mb-4">New Arrivals</p>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-5">
            Technology that<br class="hidden md:block"> fits your life.
        </h1>
        <p class="text-lg text-gray-500 max-w-xl mx-auto mb-10">
            Discover the latest in RC, electronics, gadgets, and tech essentials — curated for modern living.
        </p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}"
            class="inline-block bg-accent text-white text-sm font-semibold px-8 py-3 rounded-full hover:bg-accent-hover transition">
            Shop Now
        </a>
    </section>

    {{-- Category Grid --}}
    @if(isset($categories) && count($categories))
    <section class="max-w-8xl mx-auto px-5 pb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Shop by Category</h2>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($categories as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat['slug']) }}"
                    class="group flex flex-col items-center p-4 rounded-xl border border-gray-100 hover:border-accent hover:shadow-md transition-all no-underline">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-3 text-xl group-hover:bg-accent group-hover:text-white transition">
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
                    <span class="text-xs font-medium text-gray-500 group-hover:text-accent transition text-center">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- CTA Banner --}}
    <section class="max-w-8xl mx-auto px-5 pb-12">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-10 md:p-14 text-center text-white">
            <h2 class="text-2xl md:text-3xl font-bold mb-3">Free shipping on orders over $50</h2>
            <p class="text-blue-200 mb-6">Shop our entire collection with confidence.</p>
            <a href="{{ route('shop.product_or_category.index', 'shop') }}"
                class="inline-block bg-white text-blue-700 text-sm font-semibold px-8 py-3 rounded-full hover:bg-blue-50 transition">
                Start Shopping
            </a>
        </div>
    </section>

@endsection
