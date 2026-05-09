@extends('baxin-modern::layouts.master')

@section('title', ($category->name ?? 'Shop') . ' | Baxin Store')

@section('content')
<div class="baxin-section">
    <div class="baxin-breadcrumb">
        <a href="{{ route('shop.home.index') }}">Home</a> /
        <span style="color:#333">{{ $category->name ?? 'Shop' }}</span>
    </div>

    <div class="baxin-section-header">
        <h1 class="baxin-section-title">{{ $category->name ?? 'Shop' }}</h1>
    </div>

    {{-- Bagisto Product List Vue Component --}}
    <v-product-list category-id="{{ $category->id ?? 141 }}">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
            <div style="background:#f3f4f6;border-radius:12px;height:260px"></div>
            <div style="background:#f3f4f6;border-radius:12px;height:260px"></div>
            <div style="background:#f3f4f6;border-radius:12px;height:260px"></div>
            <div style="background:#f3f4f6;border-radius:12px;height:260px"></div>
        </div>
    </v-product-list>
</div>
@endsection
