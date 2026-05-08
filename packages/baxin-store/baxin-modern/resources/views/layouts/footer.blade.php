<footer class="bg-gray-50 border-t border-gray-100 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Baxin Store</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Modern electronics &amp; tech for everyday life.</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Shop</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="{{ route('shop.product_or_category.index', 'shop') }}" class="hover:text-gray-900 transition">All Products</a></li>
                    @foreach(($navCategories ?? collect())->take(4) as $cat)
                        <li><a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="hover:text-gray-900 transition">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Support</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-gray-900 transition">Contact Us</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition">Returns</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Legal</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-gray-900 transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-gray-900 transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 mt-10 pt-6 text-sm text-gray-400 text-center">
            &copy; {{ date('Y') }} Baxin Store. All rights reserved.
        </div>
    </div>
</footer>
