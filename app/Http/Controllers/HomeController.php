<?php

namespace App\Http\Controllers;

use App\Category;
use Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Cache::rememberForever('categories', function () {
            return Category::query()->orderBy('name')->get();
        });

        return view('home', [
            'categories' => $categories,
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
}
