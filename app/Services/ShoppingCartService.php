<?php
/**
 * Created by PhpStorm.
 * User: cjmax
 * Date: 08.03.2018
 * Time: 0:58
 */

namespace App\Services;


use App\Product;

class ShoppingCartService
{
    public static function getItems(bool $formatted = true): array
    {
        if (\Auth::guest()) {
            $shoppingCartItems = session()->get('shopping-cart-items', []);
        } else {
            $shoppingCartItems = \Auth::user()->products()->count()
                ? collect(\Auth::user()->products)->map(function ($item) {
                    return [
                        'id'    => $item->product_id,
                        'count' => $item->count,
                    ];
                })->toArray()
                : [];
        }

        if (!$formatted) return $shoppingCartItems;


        $productIds = data_get($shoppingCartItems, '*.id');
        $products = Product::query()->whereIn('id', $productIds)->get();
        $items = collect($shoppingCartItems)->map(function ($item) use ($products) {

            $product = $products->firstWhere('id', $item['id']);

            return [
                'id'        => $item['id'],
                'count'     => $item['count'],
                'name'      => $product->name,
                'available' => $product->is_available,
                'image'     => $product->images
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

        return $items;
    }

    public static function putItem(Product $product, int $count = 1): bool
    {
        $shoppingCartItems = collect(self::getItems());

        if (\Auth::guest()) {

            if ($shoppingCartItems->firstWhere('id', $product->id)) {
                $shoppingCartItems->transform(function ($item) use ($product, $count) {
                    if ($item['id'] == $product->id) {
                        $item['count'] += $count;
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

            $user = \Auth::user();
            $productItem = $user->products()->find($product->id);

            try {
                if ($productItem) {
                    $productItem->count += $count;
                    $productItem->save();
                } else {
                    $user->products()->attach($product);
                }
            } catch (\Exception $e) {
                report($e);

                return false;
            }

        }

        return true;
    }
}