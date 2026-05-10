@php
    $channel = core()->getCurrentChannel();
@endphp

<footer class="bg-gray-900 text-gray-300 mt-16">

    {{-- Top strip --}}
    <div class="border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🚚</span>
                <div>
                    <p class="text-sm font-medium text-white">Free Shipping</p>
                    <p class="text-xs text-gray-500">On orders over $49</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">🔄</span>
                <div>
                    <p class="text-sm font-medium text-white">Easy Returns</p>
                    <p class="text-xs text-gray-500">30-day return policy</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">🔒</span>
                <div>
                    <p class="text-sm font-medium text-white">Secure Payment</p>
                    <p class="text-xs text-gray-500">SSL encrypted checkout</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-2xl">💬</span>
                <div>
                    <p class="text-sm font-medium text-white">24/7 Support</p>
                    <p class="text-xs text-gray-500">We're here to help</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main footer --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-10">

            {{-- Brand --}}
            <div class="col-span-2 sm:col-span-1">
                <a href="{{ route('shop.home.index') }}" class="inline-flex items-center gap-1 mb-4">
                    <span class="text-xl font-bold text-white">Baxin</span>
                    <span class="text-xl font-light text-blue-400">.store</span>
                </a>
                <p class="text-sm text-gray-500 leading-relaxed mb-5">
                    Your one-stop shop for RC drones, robots, vehicles, and kids' toys. Quality products, fast shipping.
                </p>
                {{-- Social links --}}
                <div class="flex gap-2">
                    @foreach([
                        ['label' => 'FB', 'url' => '#', 'hover' => 'hover:bg-blue-600'],
                        ['label' => 'IG', 'url' => '#', 'hover' => 'hover:bg-pink-600'],
                        ['label' => 'YT', 'url' => '#', 'hover' => 'hover:bg-red-600'],
                        ['label' => 'TW', 'url' => '#', 'hover' => 'hover:bg-sky-500'],
                    ] as $social)
                        <a href="{{ $social['url'] }}"
                           class="w-8 h-8 bg-gray-800 {{ $social['hover'] }} rounded-full flex items-center justify-center text-xs font-medium text-gray-300 hover:text-white transition">
                            {{ $social['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Shop --}}
            <div>
                <h3 class="text-sm font-semibold text-white mb-4">Shop</h3>
                <ul class="space-y-2.5">
                    @foreach([
                        ['RC Drones', 'rc-drones'],
                        ['RC Robot', 'rc-robot'],
                        ['RC Vehicles', 'rc-vehicles'],
                        ['Dolls & Stuffed Toys','dolls-stuffed-toys'],
                        ['RC Parts', 'rc-parts'],
                        ['Flash Deals', 'special-offers'],
                        ['New Arrivals', 'new-arrivals'],
                    ] as [$name, $slug])
                        <li>
                            <a href="/{{ $slug }}"
                               class="text-sm text-gray-500 hover:text-white transition">
                                {{ $name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h3 class="text-sm font-semibold text-white mb-4">Support</h3>
                <ul class="space-y-2.5">
                    @foreach([
                        ['Help Center', '#'],
                        ['Track Order', route('shop.customers.account.orders.index')],
                        ['Returns', '#'],
                        ['Contact Us', '#'],
                        ['FAQs', '#'],
                        ['Shipping Info', '#'],
                    ] as [$label, $url])
                        <li>
                            <a href="{{ $url }}"
                               class="text-sm text-gray-500 hover:text-white transition">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Payment & Legal --}}
            <div>
                <h3 class="text-sm font-semibold text-white mb-4">We Accept</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach(['PayPal', 'Stripe', 'Razorpay', 'PayU', 'Visa', 'Mastercard'] as $pay)
                        <span class="bg-gray-800 border border-gray-700 text-xs text-gray-400 px-2.5 py-1 rounded">
                            {{ $pay }}
                        </span>
                    @endforeach
                </div>
                <h3 class="text-sm font-semibold text-white mb-4">Legal</h3>
                <ul class="space-y-2.5">
                    @foreach([
                        ['Privacy Policy', '/privacy-policy'],
                        ['Terms of Service', '/terms-of-service'],
                        ['Refund Policy', '/refund-policy'],
                        ['Cookie Policy', '/cookie-policy'],
                    ] as [$label, $url])
                        <li>
                            <a href="{{ $url }}"
                               class="text-sm text-gray-500 hover:text-white transition">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Newsletter --}}
        <div class="border-t border-gray-800 pt-8 mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-white mb-1">Stay in the loop</h3>
                    <p class="text-xs text-gray-500">Get deals, new arrivals and RC news straight to your inbox.</p>
                </div>
                <form class="flex w-full sm:w-auto gap-2" onsubmit="event.preventDefault(); showToast('📧 Newsletter coming soon!', 'info'); return false;">
                    <input type="email" placeholder="your@email.com"
                           class="flex-1 sm:w-56 bg-gray-800 border border-gray-700 text-sm text-white px-4 py-2.5 rounded-full outline-none focus:border-blue-500 placeholder-gray-600" />
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-medium px-5 py-2.5 rounded-full whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-600">
            <p>&copy; {{ date('Y') }} Baxin Store &mdash; Mirai Global Solutions. All rights reserved.</p>
            <div class="flex items-center gap-1">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span>All systems operational</span>
            </div>
        </div>
    </div>
</footer>
