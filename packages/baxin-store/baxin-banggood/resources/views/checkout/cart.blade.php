@extends('baxin-banggood::layouts.master')
@section('title', 'Shopping Cart — Baxin Store')

@section('content')

<div class="max-w-8xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">🛒 Shopping Cart</h1>

    {{-- Let Bagisto's Vue cart component handle the actual cart logic --}}
    <div id="app">
        <bagisto-cart></bagisto-cart>
    </div>

    {{-- Fallback for non-Vue --}}
    <noscript>
        <div class="text-center py-16 text-gray-500">
            <p>JavaScript is required for the cart. Please enable JavaScript or <a href="{{ route('shop.home.index') }}" class="text-brand-600 underline">continue shopping</a>.</p>
        </div>
    </noscript>
</div>

@endsection
