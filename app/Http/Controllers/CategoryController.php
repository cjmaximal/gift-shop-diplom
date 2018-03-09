<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Cache;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $perPage = 12;

    public function show(Request $request, Category $category)
    {
        $sort = in_array($request->input('sort'), ['created_at', 'name', 'price']) ? $request->input('sort') : 'price';
        $dir = in_array($request->input('dir'), ['asc', 'desc']) ? $request->input('dir') : 'asc';
        $priceFrom = (float)$request->input('price_from', 0);
        $priceTo = (float)$request->input('price_to', Product::query()->max('price'));

        $products = $category->products()
            ->with(['categories', 'images'])
            ->whereBetween('price', [$priceFrom, $priceTo])
            ->orderBy($sort, $dir)
            ->paginate($this->perPage);

        return view('categories', [
            'category'   => $category,
            'products'   => $products,
            'dir'        => $dir,
            'sort'       => $sort,
        ]);
    }
}
