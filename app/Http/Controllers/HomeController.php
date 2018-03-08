<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Services\ShoppingCartService;
use Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Cache::rememberForever('categories', function () {
            return Category::query()->orderBy('name')->has('products')->get();
        });

        $categoriesCollectionChunk = collect($categories)
            ->filter(function (Category $item) {
                return $item->products()->count() >= 3;
            })
            ->shuffle()
            ->chunk(3)
            ->first();

        $products = [];
        if ($categoriesCollectionChunk) {
            $products = $categoriesCollectionChunk->map(function (Category $categoryItem) {
                return [
                    'category' => $categoryItem,
                    'products' => $categoryItem
                        ->products()
                        ->with(['categories', 'images'])
                        ->limit(4)
                        ->get(),
                ];
            });
        }

        return view('home', [
            'categories'         => $categories,
            'categoriesProducts' => $products,
        ]);
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function conditions()
    {
        return view('conditions');
    }

    public function ajaxAddToCart(Request $request, Product $product)
    {
        $count = $request->input('count', 1);

        ShoppingCartService::putItem($product, $count);
        $shoppingCartItems = ShoppingCartService::getItems();

        return response()->json([
            'count' => count($shoppingCartItems),
            'items' => $shoppingCartItems,
        ]);
    }
}
