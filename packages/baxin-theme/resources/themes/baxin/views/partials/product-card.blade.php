<div class="baxin-product-card bg-white rounded-lg overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
    {{-- Image --}}
    <a href="{{ route('shop.product_or_category.index', $product->url_key) }}" class="block relative overflow-hidden">
        <div class="aspect-square bg-gray-50 flex items-center justify-center p-4">
            @if($product->base_image_url ?? $product->flat->base_image_url ?? null)
                <img src="{{ $product->base_image_url ?? $product->flat->base_image_url }}"
                     alt="{{ $product->name ?? $product->flat->name }}"
                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                     loading="lazy">
            @else
                <span class="text-4xl text-gray-300">📦</span>
            @endif
        </div>

        {{-- Badges --}}
        @if(($product->flat->special_price ?? 0) > 0)
            <span class="absolute top-2 left-2 bg-danger text-white text-xs font-bold px-2 py-1 rounded-full">SALE</span>
        @elseif(($product->flat->new ?? 0) == 1)
            <span class="absolute top-2 left-2 bg-accent text-white text-xs font-bold px-2 py-1 rounded-full">NEW</span>
        @endif
    </a>

    {{-- Info --}}
    <div class="p-3">
        {{-- Title --}}
        <a href="{{ route('shop.product_or_category.index', $product->url_key) }}" class="block">
            <h3 class="product-title-clamp text-sm font-medium text-gray-800 hover:text-accent transition leading-5 mb-2">
                {{ $product->name ?? $product->flat->name }}
            </h3>
        </a>

        {{-- Price --}}
        <div class="flex items-center gap-2">
            @if(($product->flat->special_price ?? 0) > 0)
                <span class="text-lg font-bold text-danger">${{ number_format($product->flat->special_price, 2) }}</span>
                <span class="text-sm text-gray-400 line-through">${{ number_format($product->flat->price, 2) }}</span>
            @else
                <span class="text-lg font-bold text-gray-900">${{ number_format($product->flat->price ?? 0, 2) }}</span>
            @endif
        </div>

        {{-- Add to Cart --}}
        @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
            <form action="{{ route('shop.checkout.cart.store', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="baxin-btn baxin-btn-outline w-full text-xs py-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    Add to Cart
                </button>
            </form>
        @endif
    </div>
</div>
