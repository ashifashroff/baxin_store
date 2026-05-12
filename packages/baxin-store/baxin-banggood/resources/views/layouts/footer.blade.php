{{-- Footer inspired by Banggood: dark, multi-column, trust badges, newsletter --}}
<footer class="bg-gray-900 text-gray-300 mt-16">

    {{-- Newsletter bar --}}
    <div class="bg-brand-600">
        <div class="max-w-8xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center gap-3">
            <span class="text-white font-semibold text-sm">📧 Get 10% OFF — Subscribe to our newsletter</span>
            <form class="flex flex-1 max-w-md w-full" onsubmit="event.preventDefault(); showToast('Newsletter coming soon!');">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-2.5 rounded-l-full text-sm text-gray-900 focus:outline-none" required>
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-r-full text-sm font-medium hover:bg-gray-800 transition">Subscribe</button>
            </form>
        </div>
    </div>

    {{-- Trust badges --}}
    <div class="border-b border-gray-800">
        <div class="max-w-8xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🚚</span>
                <div><span class="text-white text-sm font-medium">Free Shipping</span><br><span class="text-xs text-gray-400">On orders over $49</span></div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">↩️</span>
                <div><span class="text-white text-sm font-medium">Easy Returns</span><br><span class="text-xs text-gray-400">30-day return policy</span></div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">🔒</span>
                <div><span class="text-white text-sm font-medium">Secure Payment</span><br><span class="text-xs text-gray-400">SSL encrypted checkout</span></div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">💬</span>
                <div><span class="text-white text-sm font-medium">24/7 Support</span><br><span class="text-xs text-gray-400">Always here to help</span></div>
            </div>
        </div>
    </div>

    {{-- Main footer columns --}}
    <div class="max-w-8xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div>
            <h3 class="text-white font-semibold text-sm mb-4">Shop</h3>
            @php
                $footerCats = \Illuminate\Support\Facades\DB::table('categories')
                    ->join('category_translations', function($j) { $j->on('categories.id', '=', 'category_translations.category_id')->where('category_translations.locale', 'en'); })
                    ->where('categories.parent_id', 141)
                    ->select('categories.slug', 'category_translations.name')
                    ->orderBy('categories.position')
                    ->limit(6)
                    ->get();
            @endphp
            @foreach($footerCats as $cat)
                <a href="{{ route('shop.product_or_category.index', $cat->slug) }}" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">{{ $cat->name }}</a>
            @endforeach
        </div>
        <div>
            <h3 class="text-white font-semibold text-sm mb-4">Customer Service</h3>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">Contact Us</a>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">FAQs</a>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">Shipping Info</a>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">Returns & Refunds</a>
        </div>
        <div>
            <h3 class="text-white font-semibold text-sm mb-4">Company</h3>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">About Us</a>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">Privacy Policy</a>
            <a href="#" class="block text-gray-400 text-sm hover:text-white transition mb-2 no-underline">Terms of Service</a>
        </div>
        <div>
            <h3 class="text-white font-semibold text-sm mb-4">Follow Us</h3>
            <div class="flex gap-3">
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 transition no-underline" aria-label="Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 transition no-underline" aria-label="Instagram">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 transition no-underline" aria-label="YouTube">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
            </div>
            <div class="mt-4">
                <span class="text-xs text-gray-500">Accepted Payments</span>
                <div class="flex gap-2 mt-2">
                    <span class="bg-gray-800 rounded px-2 py-1 text-xs text-gray-400">Visa</span>
                    <span class="bg-gray-800 rounded px-2 py-1 text-xs text-gray-400">MC</span>
                    <span class="bg-gray-800 rounded px-2 py-1 text-xs text-gray-400">PayPal</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-gray-800">
        <div class="max-w-8xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span class="text-xs text-gray-500">© {{ date('Y') }} Baxin Store. All rights reserved.</span>
            <span class="text-xs text-gray-600">Powered by Bagisto</span>
        </div>
    </div>
</footer>
