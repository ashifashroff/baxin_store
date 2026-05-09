<?php

namespace BaxinStore\BaxinModern\Http\ViewComposers;

use Illuminate\View\View;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
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

            $productIds = DB::table('product_categories')
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
