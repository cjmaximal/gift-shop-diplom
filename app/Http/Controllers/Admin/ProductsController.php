<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $products = Product::query()
            ->orderBy('name')
            ->forPage($request->get('page', $this->page), $this->perPage);

        dd($products);
    }
}
