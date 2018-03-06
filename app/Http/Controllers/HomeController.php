<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
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
        $shoppingCartItems = [];
        $count = 1;

        if (\Auth::guest()) {

            if (session()->has('shopping-cart-items')) {
                $shoppingCartItems = session()->get('shopping-cart-items', []);
            }

            $shoppingCartItems = collect($shoppingCartItems);
            if ($shoppingCartItems->firstWhere('id', $product->id)) {
                $shoppingCartItems->transform(function ($item) use ($product) {
                    if ($item['id'] == $product->id) {
                        $item['count']++;
                    }

                    return $item;
                });
            } else {
                $shoppingCartItems->push([
                    'id'    => $product->id,
                    'count' => $count,
                ]);
            }

            session()->put('shopping-cart-items', $shoppingCartItems->toArray());
        } else {

        }

        if ($shoppingCartItems->isEmpty()) return response()->json(['items' => []]);

        $productIds = $shoppingCartItems->pluck('id');
        $products = Product::query()->whereIn('id', $productIds)->where('is_available', true)->get();

        $items = $shoppingCartItems->mapWithKeys(function ($item) use ($products) {

            if (!$product = $products->firstWhere('id', $item['id'])) return false;

            return [
                'id'    => $item['id'],
                'count' => $item['count'],
                'name'  => $product->name,
                'image' => $product->images
                    ? route('imagecache', [
                        'template' => 'small',
                        'filename' => basename($product->images->first()->src),
                    ])
                    : route('imagecache', [
                        'template' => 'small',
                        'filename' => 'no-image.png',
                    ]),
            ];
        })->toArray();

        return response()->json(['items' => $items]);
    }
}
