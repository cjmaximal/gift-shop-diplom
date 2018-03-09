<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Services\ShoppingCartService;
use Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()->orderBy('name')->has('products')->get();

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

    public function ajaxRemoveFromCart(Request $request, Product $product)
    {
        $completely = (bool)$request->input('completely', 0);

        ShoppingCartService::removeItem($product, $completely);
        $shoppingCartItems = ShoppingCartService::getItems();

        return response()->json([
            'count' => count($shoppingCartItems),
            'items' => $shoppingCartItems,
        ]);
    }
}
