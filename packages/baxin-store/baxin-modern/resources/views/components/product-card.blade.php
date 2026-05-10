{{--
    Usage:
    @include('baxin-modern::components.product-card', ['product' => $product])

    Works with both Eloquent models and stdClass (flat) objects from DB queries.
    stdClass props: id, name, url_key, price, special_price, image_url
    Eloquent props: uses getTypeInstance(), base_image, etc.

    Optional props:
    - $showBadge (bool) — show New/Sale badge, default true
    - $showRating (bool) — show star rating, default true
    - $showWishlist (bool) — show wishlist button, default true
--}}

@php
    $isEloquent = $product instanceof \Illuminate\Database\Eloquent\Model;
    if ($isEloquent) {
        $price = $product->getTypeInstance()->getMinimalPrice();
        $special = $product->special_price;
        $image = $product->base_image->small_image_url ?? asset('themes/baxin-modern/images/placeholder.png');
    } else {
        $price = $product->price;
        $special = $product->special_price ?? null;
        $image = $product->image_url ?? asset('themes/baxin-modern/images/placeholder.png');
    }
    $discount = $special ? round((($price - $special) / $price) * 100) : 0;
    $showBadge = $showBadge ?? true;
    $showRating = $showRating ?? true;
    $showWishlist = $showWishlist ?? true;
@endphp

<a href="{{ route('shop.product_or_category.index', $product->url_key) }}"
   class="group relative bg-white border border-gray-100 rounded-xl p-3 flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 no-underline">

    {{-- Wishlist button --}}
    @if($showWishlist)
        <button onclick="event.preventDefault(); addToWishlist({{ $product->id }})"
                class="absolute top-3 right-3 w-7 h-7 bg-white border border-gray-100 rounded-full flex items-center justify-center text-gray-300 hover:text-red-400 hover:border-red-200 transition opacity-0 group-hover:opacity-100 z-10 shadow-sm text-sm">
            ♡
        </button>
    @endif

    {{-- Image --}}
    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-3 relative">
        @if($image)
            <img src="{{ $image }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" />
        @else
            <div class="flex items-center justify-center h-full text-3xl text-gray-200">📦</div>
        @endif

        {{-- Badges --}}
        @if($showBadge)
            @if($discount > 0)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                    -{{ $discount }}%
                </span>
            @elseif($isEloquent && $product->new)
                <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-medium px-2 py-0.5 rounded">
                    New
                </span>
            @endif
        @endif
    </div>

    {{-- Product name --}}
    <p class="text-xs text-gray-700 leading-relaxed mb-2 flex-1"
       style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
        {{ $product->name }}
    </p>

    {{-- Rating --}}
    @if($showRating && $isEloquent && ($product->reviews_count ?? 0) > 0)
        <div class="flex items-center gap-1 mb-1.5">
            <div class="flex text-yellow-400 text-xs">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($product->avg_rating ?? 0) ? '★' : '☆' }}
                @endfor
            </div>
            <span class="text-xs text-gray-400">({{ $product->reviews_count }})</span>
        </div>
    @endif

    {{-- Price --}}
    <div class="flex items-center gap-1.5 flex-wrap">
        @if($special)
            <span class="text-sm font-bold text-red-500">${{ number_format($special, 2) }}</span>
            <span class="text-xs text-gray-400 line-through">${{ number_format($price, 2) }}</span>
        @else
            <span class="text-sm font-bold text-gray-900">${{ number_format($price, 2) }}</span>
        @endif
    </div>

    {{-- Add to cart quick button --}}
    <button onclick="event.preventDefault(); quickAddToCart({{ $product->id }})"
            class="mt-2.5 w-full bg-blue-600 text-white text-xs font-medium py-2 rounded-full hover:bg-blue-700 transition opacity-0 group-hover:opacity-100">
        Add to Cart
    </button>

</a>
