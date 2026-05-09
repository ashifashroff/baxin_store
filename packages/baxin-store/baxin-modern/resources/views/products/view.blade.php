@extends('baxin-modern::layouts.master')

@section('title', ($product->name ?? 'Product') . ' | Baxin Store')

@section('content')
<div class="baxin-section" style="padding-top:32px">
    <div class="baxin-breadcrumb">
        <a href="{{ route('shop.home.index') }}">Home</a> /
        @if(isset($product) && $product->categories->count())
            @php $cat = $product->categories->first(); @endphp
            <a href="{{ route('shop.product_or_category.index', $cat->slug) }}">{{ $cat->name }}</a> /
        @endif
        <span style="color:#333">{{ $product->name ?? 'Product' }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;max-width:1000px">
        {{-- Image --}}
        <div>
            <div style="aspect-ratio:1;background:#f9fafb;border-radius:16px;overflow:hidden;border:1px solid #f0f0f0">
                @if($product->base_image_url ?? null)
                    <img src="{{ $product->base_image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:contain;padding:32px">
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:48px;color:#e5e7eb">📦</div>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div>
            <h1 style="font-size:24px;font-weight:700;color:#0a0a0a;margin-bottom:8px">{{ $product->name ?? '' }}</h1>

            <div style="margin-bottom:24px">
                @if(($product->special_price ?? 0) > 0)
                    <span style="font-size:28px;font-weight:700;color:#2563EB">${{ number_format($product->special_price, 2) }}</span>
                    <span style="font-size:16px;color:#9ca3af;text-decoration:line-through;margin-left:8px">${{ number_format($product->price, 2) }}</span>
                @else
                    <span style="font-size:28px;font-weight:700;color:#0a0a0a">${{ number_format($product->price ?? 0, 2) }}</span>
                @endif
            </div>

            @if($product->short_description ?? null)
                <div style="font-size:14px;color:#6b7280;line-height:1.6;margin-bottom:24px">{!! $product->short_description !!}</div>
            @endif

            <div style="margin-bottom:32px">
                <button onclick="addToCart({{ $product->id ?? 0 }})" class="baxin-btn-primary" style="width:100%;text-align:center">Add to Cart</button>
            </div>

            <div style="border-top:1px solid #f0f0f0;padding-top:20px;font-size:14px;color:#6b7280;line-height:2">
                <p>🚚 Free shipping on orders over $50</p>
                <p>↩️ 30-day return policy</p>
                <p>🔒 Secure checkout</p>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($product->description ?? null)
        <div style="margin-top:48px;border-top:1px solid #f0f0f0;padding-top:32px;max-width:1000px">
            <h2 style="font-size:20px;font-weight:700;margin-bottom:16px">Description</h2>
            <div style="font-size:14px;color:#6b7280;line-height:1.8">{!! $product->description !!}</div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function addToCart(productId) {
    var qty = document.getElementById('qty') ? document.getElementById('qty').value : 1;
    fetch('/api/checkout/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
        },
        body: JSON.stringify({ product_id: productId, quantity: qty })
    }).then(function(r) { return r.json(); }).then(function(data) {
        if(data.message) alert(data.message);
        else window.location.href = '/checkout/cart';
    }).catch(function() { alert('Error adding to cart'); });
}
</script>
@endpush
@endsection
