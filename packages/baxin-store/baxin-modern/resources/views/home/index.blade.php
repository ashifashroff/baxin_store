@extends('baxin-modern::layouts.master')

@section('title', 'Baxin Store — Modern Electronics & Tech')

@section('content')

    {{-- Hero --}}
    <div class="baxin-hero">
        <p class="baxin-hero-label">New Arrivals</p>
        <h1>Technology that<br>fits your life.</h1>
        <p>Discover the latest in RC, electronics, gadgets, and tech essentials — curated for modern living.</p>
        <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="baxin-btn-primary">Shop Now</a>
    </div>

    {{-- Category Grid --}}
    @if(isset($categories) && count($categories))
    <div class="baxin-categories">
        <div class="baxin-section-header">
            <h2 class="baxin-section-title">Shop by Category</h2>
        </div>
        <div class="baxin-cat-grid">
            @foreach($categories as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat['slug']) }}" class="baxin-cat-icon">
                    <div class="baxin-cat-emoji">
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
                    <span class="baxin-cat-name">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CTA Banner --}}
    <div class="baxin-cta">
        <div class="baxin-cta-inner">
            <h2>Free shipping on orders over $50</h2>
            <p>Shop our entire collection with confidence.</p>
            <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="baxin-btn-primary">Start Shopping</a>
        </div>
    </div>

@endsection
