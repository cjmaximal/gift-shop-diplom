<?php

namespace App\Services;

use App\Product;
use App\User;

class ShoppingCartService
{
    public static function getItems(bool $formatted = true): array
    {
        if (\Auth::check()) {

            $user = \Auth::user();
            $shoppingCartItems = \Auth::user()->products()->count()
                ? $user->products->map(function (Product $product) {

                    return [
                        'id'    => $product->id,
                        'count' => $product->pivot->count,
                    ];
                })->toArray()
                : [];
        } else {
            $shoppingCartItems = session()->get('shopping-cart-items', []);
        }

        if (!$formatted) {
            return $shoppingCartItems;
        }


        $productIds = data_get($shoppingCartItems, '*.id');
        $products = Product::query()->whereIn('id', $productIds)->get();
        $items = collect($shoppingCartItems)->map(function ($item) use ($products) {

            $product = $products->firstWhere('id', $item['id']);

            if (!$product) {
                self::removeItem($item['id'], true);

                return [];
            }

            return [
                'id'        => $product->id,
                'slug'      => $product->slug,
                'count'     => (int)$item['count'],
                'name'      => $product->name,
                'price'     => (double)$product->price,
                'sum'       => round($item['count'] * $product->price, 2),
                'available' => $product->is_available,
                'image'     => $product->images->isNotEmpty()
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
        if (\Auth::check()) {

            $user = \Auth::user();
            $userProduct = $user->products()->find($product->id);

            if ($userProduct) {
                $count += $userProduct->pivot->count;
                $user->products()->updateExistingPivot($userProduct->id, ['count' => $count]);
            } else {
                $user->products()->attach($product->id, ['count' => $count]);
            }
        } else {

            $shoppingCartItems = collect(self::getItems());
            $item = $shoppingCartItems->firstWhere('id', $product->id);
            if ($item) {
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
        }


        return true;
    }

    public static function removeItem(Product $product, bool $completely = false): bool
    {
        if (\Auth::check()) {

            $user = \Auth::user();
            $product = $user->products()->find($product->id);

            if (!$product) {
                return true;
            }

            if ($completely || $product->pivot->count <= 1) {
                $user->products()->detach($product->id);
            } elseif (!$completely && $product->pivot->count > 1) {
                $count = $product->pivot->count - 1;
                $user->products()->updateExistingPivot($product->id, ['count' => $count]);
            }
        } else {
            $shoppingCartItems = collect(self::getItems());
            $item = $shoppingCartItems->firstWhere('id', $product->id);

            if ($item) {

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
        }

        return true;
    }

    public static function flush(): void
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $user->products()->sync([]);
        } else {
            session()->forget('shopping-cart-items');
        }
    }

    public static function sync(User $user): void
    {
        $shoppingCartItems = session()->get('shopping-cart-items', []);
        $productIds = collect($shoppingCartItems)->pluck('id');
        $user->products()->sync($productIds, false);

        session()->forget('shopping-cart-items');
    }
}