<?php

namespace App\Services;

use App\Category;
use Cache;

class MenuService
{
    public static function get(): array
    {
        $categories = Cache::rememberForever('categories', function () {
            return Category::query()->orderBy('name')->has('products')->get()->toArray();
        });

        return $categories;
    }
}