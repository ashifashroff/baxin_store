{{-- Reusable product card — Banggood style with hover effects, discount badge, wishlist --}}
@php
    $isProductModel = $product instanceof \Webkul\Product\Models\Product;
    $isFlatModel = $product instanceof \Webkul\Product\Models\ProductFlat;
    $isStdClass = !$isProductModel && !$isFlatModel;

    // ID
    $productId = $product->product_id ?? $product->id ?? 0;

    // Name
    $name = $product->name ?? '';

    // URL
    $urlKey = $product->url_key ?? '';
    $productUrl = $urlKey ? route('shop.product_or_category.index', $urlKey) : '#';

    // Price
    $price = (float) ($product->price ?? 0);
    $specialPrice = (float) ($product->special_price ?? 0);
    $hasDiscount = $specialPrice > 0 && $specialPrice < $price;
    $discount = $hasDiscount ? round(($price - $specialPrice) / $price * 100) : 0;

    // Image
    $imagePath = $product->image_path ?? null;
    if (!$imagePath && $isProductModel) {
        $imagePath = \Illuminate\Support\Facades\DB::table('product_images')
            ->where('product_id', $productId)->orderBy('id')->value('path');
    }
    $imageUrl = $imagePath ? 'https://baxin.store/cache/medium/' . $imagePath : null;

    // Category
    $categoryName = $product->category_name ?? null;
@endphp

<div class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
    {{-- Image --}}
    <a href="{{ $productUrl }}" class="block relative aspect-square bg-gray-50 overflow-hidden no-underline">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300" loading="lazy">
        @else
            <div class="flex items-center justify-center h-full text-4xl text-gray-200">📦</div>
        @endif

        {{-- Discount badge --}}
        @if($hasDiscount)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded">-{{ $discount }}%</span>
        @endif

        {{-- Wishlist button --}}
        <button onclick="toggleWishlist({{ $productId }})"
            class="absolute top-2 right-2 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition sm:opacity-0 sm:group-hover:opacity-100 shadow-sm"
            aria-label="Add to wishlist">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        </button>
    </a>

    {{-- Info --}}
    <div class="p-3">
        {{-- Category --}}
        @if($categoryName)
            <span class="text-[11px] text-brand-600 font-medium uppercase tracking-wide">{{ $categoryName }}</span>
        @endif

        {{-- Name --}}
        <a href="{{ $productUrl }}" class="block text-sm text-gray-800 font-medium leading-snug mt-1 line-clamp-2 hover:text-brand-600 transition no-underline min-h-[40px]">
            {{ Str::limit($name, 60) }}
        </a>

        {{-- Price --}}
        <div class="flex items-baseline gap-2 mt-2">
            @if($hasDiscount)
                <span class="text-lg font-bold text-brand-600">${{ number_format($specialPrice, 2) }}</span>
                <span class="text-sm text-gray-400 line-through">${{ number_format($price, 2) }}</span>
            @else
                <span class="text-lg font-bold text-gray-900">${{ number_format($price, 2) }}</span>
            @endif
        </div>

        {{-- Add to Cart --}}
        <button onclick="addToCart({{ $productId }})"
            class="w-full mt-3 bg-brand-600 text-white text-xs font-semibold py-2.5 rounded-lg hover:bg-brand-700 transition sm:opacity-0 sm:group-hover:opacity-100">
            Add to Cart
        </button>
    </div>
</div>
