@extends('baxin-modern::layouts.master')

@section('title', ($product->name ?? 'Product') . ' | Baxin Store')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('shop.home.index') }}" class="hover:text-gray-600 transition">Home</a>
        <span>/</span>
        @if(isset($product) && $product->categories->count())
            @php $cat = $product->categories->first(); @endphp
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="hover:text-gray-600 transition">{{ $cat->name }}</a>
        @endif
        <span>/</span>
        <span class="text-gray-700 truncate max-w-xs">{{ $product->name ?? 'Product' }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        {{-- Images --}}
        <div>
            <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100">
                @if($product->base_image_url ?? null)
                    <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-8">
                @else
                    <div class="flex items-center justify-center h-full text-6xl text-gray-200">📦</div>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 mb-2">{{ $product->name ?? '' }}</h1>

            <div class="flex items-baseline gap-3 mb-6">
                @if(($product->special_price ?? 0) > 0)
                    <span class="text-3xl font-bold text-accent">${{ number_format($product->special_price, 2) }}</span>
                    <span class="text-lg text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price ?? 0, 2) }}</span>
                @endif
            </div>

            @if($product->short_description ?? null)
                <div class="text-sm text-gray-600 leading-relaxed mb-6">{!! $product->short_description !!}</div>
            @endif

            {{-- Add to Cart via API --}}
            <div id="add-to-cart-area" class="mb-8">
                <div class="flex items-center gap-4">
                    <input type="number" id="qty" value="1" min="1" class="w-16 text-center border border-gray-200 rounded-lg py-2 text-sm">
                    <button onclick="addToCart({{ $product->id ?? 0 }})" class="flex-1 bg-accent text-white text-sm font-medium px-8 py-3 rounded-full hover:bg-blue-700 transition">Add to Cart</button>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 space-y-3 text-sm text-gray-500">
                <p>🚚 Free shipping on orders over $50</p>
                <p>↩️ 30-day return policy</p>
                <p>🔒 Secure checkout</p>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($product->description ?? null)
        <div class="mt-12 border-t border-gray-100 pt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">{!! $product->description !!}</div>
        </div>
    @endif

</section>

@push('scripts')
<script>
function addToCart(productId) {
    const qty = document.getElementById('qty').value;
    fetch('/api/checkout/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ product_id: productId, quantity: qty })
    }).then(r => r.json()).then(data => {
        if(data.message) alert(data.message);
        else window.location.href = '/checkout/cart';
    }).catch(() => alert('Error adding to cart'));
}
</script>
@endpush
@endsection
