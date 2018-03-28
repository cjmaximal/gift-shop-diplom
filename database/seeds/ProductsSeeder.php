<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear tables
        \DB::table('category_product')->delete();
        \DB::table('categories')->delete();
        \DB::table('products')->delete();

        // Categories
        $categoriesCount = 5;
        $categoriesArr = [];
        for ($i = 0; $i < $categoriesCount; $i++) {
            $iterator = $i + 1;
            $name = "Категория $iterator";
            $categoriesArr[] = [
                'name' => $name,
                'slug' => str_slug($name),
            ];
        }

        \DB::table('categories')->insert($categoriesArr);

        // Products
        $productsArr = [];
        $productsCount = 8 * $categoriesCount;
        for ($i = 0; $i < $productsCount; $i++) {
            $iterator = $i + 1;
            $name = "Продукт $iterator";
            $productsArr[] = [
                'name'  => $name,
                'slug'  => str_slug($name),
                'price' => random_int(100, 2000),
            ];
        }
        \DB::table('products')->insert($productsArr);

        $categories = \App\Category::all();
        $productChunks = \App\Product::all()->chunk(8);

        $categoryIterator = 0;
        foreach ($categories as $category) {
            $productIds = collect($productChunks[ $categoryIterator ])->pluck('id');
            $category->products()->sync($productIds);
            $categoryIterator++;
        }

        \Cache::forget('categories');
    }
}
