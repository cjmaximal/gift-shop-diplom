<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Cache;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load([
            'categories',
            'images',
        ]);

        $recommendedProducts = Product::query()->where('id', '!=', $product->id)->whereHas('categories', function ($q) use ($product) {
            $q->where('categories.id', $product->categories->pluck('id'));
        })->limit(4)->get();

        return view('product', [
            'product'             => $product,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
