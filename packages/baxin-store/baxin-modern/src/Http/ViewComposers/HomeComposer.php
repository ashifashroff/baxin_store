<?php

namespace BaxinStore\BaxinModern\Http\ViewComposers;

use Illuminate\View\View;
use Webkul\Category\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class HomeComposer
{
    protected array $targetCategories = [
        'RC Drones',
        'RC Robot',
        'RC Vehicles',
        'Dolls & Stuffed Toys',
        'RC Parts',
    ];

    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    public function compose(View $view): void
    {
        $view->with([
            'categoryBlocks' => $this->getCategoryBlocks(),
            'flashDeals' => $this->getFlashDeals(),
            'carouselSlides' => $this->getCarouselSlides(),
        ]);
    }

    protected function getProductImageUrl($productId): string
    {
        $path = DB::table('product_images')
            ->where('product_id', $productId)
            ->orderBy('id')
            ->value('path');

        return $path ? 'https://baxin.store/cache/medium/' . $path : '';
    }

    protected function getCategoryBlocks(): array
    {
        $blocks = [];

        foreach ($this->targetCategories as $name) {
            $category = $this->categoryRepository
                ->getModel()
                ->whereHas('translation', function ($q) use ($name) {
                    $q->where('name', $name);
                })
                ->where('status', 1)
                ->first();

            if (!$category) continue;

            $products = DB::table('product_flat')
                ->join('product_categories', 'product_flat.id', '=', 'product_categories.product_id')
                ->where('product_categories.category_id', $category->id)
                ->where('product_flat.locale', app()->getLocale())
                ->where('product_flat.status', 1)
                ->select('product_flat.id', 'product_flat.name', 'product_flat.url_key', 'product_flat.price', 'product_flat.special_price')
                ->orderBy('product_flat.created_at', 'desc')
                ->take(5)
                ->get();

            if ($products->isEmpty()) continue;

            // Attach image URLs
            $products->each(function ($p) {
                $p->image_url = $this->getProductImageUrl($p->id);
            });

            $blocks[] = [
                'name' => $name,
                'slug' => $category->slug,
                'products' => $products,
            ];
        }

        return $blocks;
    }

    protected function getFlashDeals()
    {
        $products = DB::table('product_flat')
            ->where('locale', app()->getLocale())
            ->where('status', 1)
            ->whereNotNull('special_price')
            ->where('special_price', '>', 0)
            ->orderBy('special_price', 'asc')
            ->select('id', 'name', 'url_key', 'price', 'special_price')
            ->take(5)
            ->get();

        $products->each(function ($p) {
            $p->image_url = $this->getProductImageUrl($p->id);
        });

        return $products;
    }

    protected function getCarouselSlides(): array
    {
        return [
            [
                'title' => 'RC Drones — Take Flight',
                'subtitle' => 'Shop the latest drones with HD cameras',
                'cta' => 'Shop Now',
                'url' => '/rc-drones',
                'bg' => '#EEF2FF',
                'image' => null,
            ],
            [
                'title' => 'RC Robots — The Future of Play',
                'subtitle' => 'Interactive robots for kids of all ages',
                'cta' => 'Explore',
                'url' => '/rc-robot',
                'bg' => '#FFF7ED',
                'image' => null,
            ],
            [
                'title' => 'Dolls & Stuffed Toys',
                'subtitle' => 'Soft, safe, and loved by every child',
                'cta' => 'View Collection',
                'url' => '/dolls-stuffed-toys',
                'bg' => '#FDF2F8',
                'image' => null,
            ],
        ];
    }
}
