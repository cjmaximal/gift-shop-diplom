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
        if (\Auth::check() == false) {
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

            if (!$product) {
                self::flush();

                return [];
            }

            return [
                'id'        => $product->id,
                'slug'      => $product->slug,
                'count'     => (int)$item['count'],
                'name'      => $product->name,
                'price'     => (double)$product->price,
                'sum'       => (double)round($item['count'] * $product->price, 2),
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

        if (\Auth::check() == false) {

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

    public static function removeItem(Product $product, bool $completely = false): bool
    {
        $shoppingCartItems = collect(self::getItems());

        if (\Auth::guest()) {

            if ($item = $shoppingCartItems->firstWhere('id', $product->id)) {

                if ($completely || $item['count'] == 1) {
                    $shoppingCartItems = $shoppingCartItems->reject(function ($value) use ($product) {
                        return $value['id'] == $product->id;
                    });
                } elseif (!$completely && $item['count'] > 1) {
                    $shoppingCartItems->transform(function ($item) use ($product) {
                        if ($item['id'] == $product->id) {
                            $item['count'] -= 1;
                        }

                        return $item;
                    });

                }
            }

            session()->put('shopping-cart-items', $shoppingCartItems->values()->toArray());

        } else {

            $user = \Auth::user();
            $productItem = $user->products()->find($product->id);

            if (!$productItem) return true;

            try {
                if ($completely || $productItem->count == 1) {
                    $user->products()->detach($product);
                } elseif (!$completely && $productItem->count > 1) {
                    $productItem->count -= 1;
                    $productItem->save();
                }
            } catch (\Exception $e) {
                report($e);

                return false;
            }

        }

        return true;
    }

    public static function flush()
    {
        if (\Auth::check() == false) {
            session()->forget('shopping-cart-items');
        } else {
            $user = \Auth::user();
            $user->products()->sync([]);
        }
    }
}