<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');

        if (session()->has('admin.product.perPage')) {
            $this->perPage = session()->get('admin.product.perPage', $this->perPage);
        } else {
            session('admin.product.perPage', $this->perPage);
        }
    }

    public function index(Request $request)
    {
        $products = Product::all()->forPage($request->get('page', $this->page), $this->perPage);

        dd($products);
    }
}
