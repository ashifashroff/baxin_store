<footer class="bg-gray-50 border-t border-gray-100 mt-16">
    <div class="max-w-8xl mx-auto px-5 py-12 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Baxin Store</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Modern electronics &amp; tech for everyday life.</p>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Shop</h3>
            <div class="space-y-2">
                <a href="{{ route('shop.product_or_category.index', 'shop') }}" class="block text-sm text-gray-500 hover:text-gray-900 transition">All Products</a>
                @foreach(($navCategories ?? collect())->take(4) as $cat)
                    <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="block text-sm text-gray-500 hover:text-gray-900 transition">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Support</h3>
            <div class="space-y-2">
                <a href="#" class="block text-sm text-gray-500 hover:text-gray-900 transition">Contact Us</a>
                <a href="#" class="block text-sm text-gray-500 hover:text-gray-900 transition">FAQ</a>
                <a href="#" class="block text-sm text-gray-500 hover:text-gray-900 transition">Returns</a>
            </div>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Legal</h3>
            <div class="space-y-2">
                <a href="#" class="block text-sm text-gray-500 hover:text-gray-900 transition">Privacy Policy</a>
                <a href="#" class="block text-sm text-gray-500 hover:text-gray-900 transition">Terms of Service</a>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-200 text-center py-5 text-sm text-gray-400">
        &copy; {{ date('Y') }} Baxin Store. All rights reserved.
    </div>
</footer>
