<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Cache;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Category $category, Product $product)
    {
        $category->load([
            'products' => function ($q) {
                $q->limit(4);
            },
        ]);
        $product->load([
            'categories',
            'images',
        ]);

        $categories = Cache::rememberForever('categories', function () {
            return Category::query()->orderBy('name')->has('products')->get();
        });

        return view('product', [
            'category'   => $category,
            'categories' => $categories,
            'product'    => $product,
        ]);
    }
}
