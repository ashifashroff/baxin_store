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

    <h1 class="text-2xl font-semibold text-gray-900 mb-6">{{ $category->name ?? 'Shop' }}</h1>

    {{-- Bagisto Product List Component --}}
    <v-product-list category-id="{{ $category->id ?? 141 }}">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="animate-pulse"><div class="bg-gray-100 rounded-xl h-64"></div></div>
            <div class="animate-pulse"><div class="bg-gray-100 rounded-xl h-64"></div></div>
            <div class="animate-pulse hidden md:block"><div class="bg-gray-100 rounded-xl h-64"></div></div>
            <div class="animate-pulse hidden lg:block"><div class="bg-gray-100 rounded-xl h-64"></div></div>
        </div>
    </v-product-list>

</section>
@endsection
