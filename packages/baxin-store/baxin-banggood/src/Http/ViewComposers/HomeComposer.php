<?php

namespace BaxinStore\BaxinBanggood\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class HomeComposer
{
    public function compose(View $view): void
    {
        // Flash deals (products with special price, sorted by discount)
        $flashDeals = DB::table('product_flat')
            ->join('product_images', 'product_flat.product_id', '=', 'product_images.product_id')
            ->join('product_categories', 'product_flat.product_id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->join('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', 'en');
            })
            ->select(
                'product_flat.product_id',
                'product_flat.name',
                'product_flat.url_key',
                'product_flat.price',
                'product_flat.special_price',
                'product_images.path as image_path',
                'category_translations.name as category_name'
            )
            ->where('product_flat.special_price', '>', 0)
            ->where('product_flat.channel', 'default')
            ->where('product_flat.locale', 'en')
            ->whereColumn('product_flat.special_price', '<', 'product_flat.price')
            ->groupBy(
                'product_flat.product_id',
                'product_flat.name',
                'product_flat.url_key',
                'product_flat.price',
                'product_flat.special_price',
                'product_images.path',
                'category_translations.name'
            )
            ->orderByRaw('(product_flat.price - product_flat.special_price) / product_flat.price DESC')
            ->limit(8)
            ->get();

        // Category blocks: top 5 categories with 6 products each
        $categoryBlocks = DB::table('categories')
            ->join('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', 'en');
            })
            ->where('categories.parent_id', 141) // Root "Shop" category
            ->select('categories.id', 'categories.slug', 'category_translations.name')
            ->orderBy('categories.position')
            ->limit(5)
            ->get()
            ->map(function ($cat) {
                $cat->products = DB::table('product_flat')
                    ->join('product_images', 'product_flat.product_id', '=', 'product_images.product_id')
                    ->join('product_categories', 'product_flat.product_id', '=', 'product_categories.product_id')
                    ->select(
                        'product_flat.product_id',
                        'product_flat.name',
                        'product_flat.url_key',
                        'product_flat.price',
                        'product_flat.special_price',
                        'product_images.path as image_path'
                    )
                    ->where('product_categories.category_id', $cat->id)
                    ->where('product_flat.channel', 'default')
                    ->where('product_flat.locale', 'en')
                    ->groupBy(
                        'product_flat.product_id',
                        'product_flat.name',
                        'product_flat.url_key',
                        'product_flat.price',
                        'product_flat.special_price',
                        'product_images.path'
                    )
                    ->orderByDesc('product_flat.product_id')
                    ->limit(6)
                    ->get();
                return $cat;
            });

        // Navigation categories for mega menu
        $navCategories = DB::table('categories')
            ->join('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', 'en');
            })
            ->where('categories.parent_id', 141)
            ->select('categories.id', 'categories.slug', 'category_translations.name', 'categories.position')
            ->orderBy('categories.position')
            ->get();

        $view->with(compact('flashDeals', 'categoryBlocks', 'navCategories'));
    }
}
