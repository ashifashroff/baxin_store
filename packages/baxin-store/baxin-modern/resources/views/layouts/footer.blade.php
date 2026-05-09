<footer class="baxin-footer">
    <div class="baxin-footer-inner">
        <div>
            <h3>Baxin Store</h3>
            <p>Modern electronics &amp; tech for everyday life.</p>
        </div>
        <div>
            <h3>Shop</h3>
            <p><a href="{{ route('shop.product_or_category.index', 'shop') }}">All Products</a></p>
            @foreach(($navCategories ?? collect())->take(4) as $cat)
                <p><a href="{{ route('shop.product_or_category.index', $cat->slug) }}">{{ $cat->name }}</a></p>
            @endforeach
        </div>
        <div>
            <h3>Support</h3>
            <p><a href="#">Contact Us</a></p>
            <p><a href="#">FAQ</a></p>
            <p><a href="#">Returns</a></p>
        </div>
        <div>
            <h3>Legal</h3>
            <p><a href="#">Privacy Policy</a></p>
            <p><a href="#">Terms of Service</a></p>
        </div>
    </div>
    <div class="baxin-footer-bottom">
        &copy; {{ date('Y') }} Baxin Store. All rights reserved.
    </div>
</footer>
