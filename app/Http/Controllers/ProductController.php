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

        return view('product', [
            'category'   => $category,
            'product'    => $product,
        ]);
    }
}
