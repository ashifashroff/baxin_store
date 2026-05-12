@extends('baxin-banggood::layouts.master')
@section('title', 'Search Results — Baxin Store')

@push('styles')
<style>.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }</style>
@endpush

@section('content')

{{-- Search header --}}
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-8xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-900">
            @if(request('query'))
                Search: "{{ request('query') }}"
            @else
                Search Products
            @endif
        </h1>
        <form action="{{ route('shop.search.index') }}" method="GET" class="mt-4 max-w-xl">
            <div class="flex border-2 border-brand-500 rounded-full overflow-hidden">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Search for RC drones, robots, vehicles, parts..." class="flex-1 px-5 py-3 text-sm focus:outline-none" autofocus>
                <button type="submit" class="bg-brand-600 text-white px-6 hover:bg-brand-700 transition">Search</button>
            </div>
        </form>
    </div>
</div>

{{-- Results --}}
<div class="max-w-8xl mx-auto px-4 py-8">
    @if(isset($products) && $products->count() > 0)
        <p class="text-sm text-gray-500 mb-6">{{ $products->total() ?? count($products) }} results found</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($products as $product)
                @include('baxin-banggood::components.product-card', ['product' => $product])
            @endforeach
        </div>
        @if(method_exists($products, 'links'))
            <div class="mt-8 flex justify-center">{{ $products->links() }}</div>
        @endif
    @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">No results found</h2>
            <p class="text-gray-500">Try different keywords or browse our categories.</p>
            <a href="{{ route('shop.home.index') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-3 rounded-full text-sm font-semibold hover:bg-brand-700 transition no-underline">Back to Home</a>
        </div>
    @endif
</div>

@endsection
