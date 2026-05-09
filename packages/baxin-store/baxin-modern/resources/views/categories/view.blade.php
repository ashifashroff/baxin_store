@extends('baxin-modern::layouts.master')

@section('title', ($category->name ?? 'Shop') . ' | Baxin Store')

@section('content')
<section class="max-w-8xl mx-auto px-5 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('shop.home.index') }}" class="hover:text-gray-600 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700">{{ $category->name ?? 'Shop' }}</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $category->name ?? 'Shop' }}</h1>
    </div>

    {{-- Bagisto Product List --}}
    <v-product-list category-id="{{ $category->id ?? 141 }}">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden md:block"></div>
            <div class="bg-gray-100 rounded-xl h-64 animate-pulse hidden lg:block"></div>
        </div>
    </v-product-list>
</section>
@endsection
