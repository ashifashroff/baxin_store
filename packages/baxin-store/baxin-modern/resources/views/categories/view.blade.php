@extends('baxin-modern::layouts.master')
@section('title', ($category->name ?? 'Shop') . ' — Baxin Store')

@push('styles')
<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
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
        <span class="text-gray-900 font-medium">{{ $category->name ?? 'Shop' }}</span>
    </nav>
</div>

<div class="max-w-7xl mx-auto px-4 pb-16">
    <h1 class="text-xl font-bold text-gray-900 mb-6">{{ $category->name ?? 'Shop' }}</h1>

    {{-- Bagisto Product List --}}
    <v-product-list category-id="{{ $category->id ?? 141 }}">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden md:block"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden lg:block"></div>
        </div>
    </v-product-list>
</div>

@endsection
