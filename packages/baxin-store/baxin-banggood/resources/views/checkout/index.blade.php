@extends('baxin-banggood::layouts.master')
@section('title', 'Checkout — Baxin Store')

@section('content')

<div class="max-w-8xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>

    {{-- Bagisto Vue checkout component --}}
    <div id="app">
        <bagisto-checkout></bagisto-checkout>
    </div>
</div>

@endsection
