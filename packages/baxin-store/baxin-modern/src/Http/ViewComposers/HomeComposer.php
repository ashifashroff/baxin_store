<?php

namespace BaxinStore\BaxinModern\Http\ViewComposers;

use Illuminate\View\View;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Carbon\Carbon;

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
        protected CategoryRepository $categoryRepository,
        protected ProductFlatRepository $productFlatRepository
    ) {}

    public function compose(View $view): void
    {
        $view->with([
            'categoryBlocks' => $this->getCategoryBlocks(),
            'flashDeals' => $this->getFlashDeals(),
            'carouselSlides' => $this->getCarouselSlides(),
        ]);
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

            $productIds = \DB::table('product_categories')
                ->where('category_id', $category->id)
                ->pluck('product_id');

            $products = $this->productFlatRepository
                ->getModel()
                ->whereIn('id', $productIds)
                ->where('locale', app()->getLocale())
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            if ($products->isEmpty()) continue;

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
        return $this->productFlatRepository
            ->getModel()
            ->where('locale', app()->getLocale())
            ->where('status', 1)
            ->whereNotNull('special_price')
            ->where('special_price', '>', 0)
            ->orderBy('special_price', 'asc')
            ->take(5)
            ->get();
    }

    protected function getCarouselSlides(): array
    {
        return [
            [
                'title' => 'RC Drones',
                'subtitle' => 'Explore the skies with our latest FPV & camera drones',
                'cta' => 'Shop Drones',
                'url' => route('shop.product_or_category.index', 'rc-drones'),
                'gradient' => 'from-blue-600 to-indigo-800',
                'emoji' => '🚁',
            ],
            [
                'title' => 'RC Vehicles',
                'subtitle' => 'High-speed cars, trucks & buggies for every terrain',
                'cta' => 'Shop Vehicles',
                'url' => route('shop.product_or_category.index', 'rc-vehicles'),
                'gradient' => 'from-orange-500 to-red-600',
                'emoji' => '🏎️',
            ],
            [
                'title' => 'Musical Instruments',
                'subtitle' => 'Guitars, keyboards & more at unbeatable prices',
                'cta' => 'Shop Instruments',
                'url' => route('shop.product_or_category.index', 'musical-instruments'),
                'gradient' => 'from-purple-600 to-pink-600',
                'emoji' => '🎸',
            ],
        ];
    }
}
