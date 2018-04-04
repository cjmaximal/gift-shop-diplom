<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use App\Order;
use App\Services\ShoppingCartService;
use Auth;
use Illuminate\Http\Request;
use Mail;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::query()->with('products')->findOrFail($id);

        $items = $order->products->map(function ($item) {
            return [
                'name'  => $item->name,
                'link'  => route('home.product.show', ['product' => $item->slug]),
                'price' => $item->pivot->price,
                'count' => $item->pivot->count,
                'sum'   => $item->pivot->price * $item->pivot->count,
            ];
        })->toArray();
        $statuses = Order::getStatuses();

        return view('order.show', [
            'order'    => $order,
            'items'    => $items,
            'statuses' => $statuses,
        ]);
    }

    public function confirm()
    {
        if (empty(ShoppingCartService::getItems(false))) {
            return redirect()->route('home.shopping_cart');
        }

        return view('order.confirm', ['shoppingCartItems' => ShoppingCartService::getItems()]);
    }

    public function address()
    {
        if (empty(ShoppingCartService::getItems(false))) {
            return redirect()->route('home.shopping_cart');
        }

        return view('order.address');
    }

    public function make(Request $request)
    {
        if (empty(ShoppingCartService::getItems(false))) {
            return redirect()->route('home.shopping_cart')
                ->with('error', 'Ваша корзина уже пуста!');
        }

        $validatedData = $request->validate([
            'surname'           => 'nullable|alpha',
            'name'              => 'required|alpha',
            'patronymic'        => 'nullable|alpha',
            'phone'             => 'nullable',
            'email'             => 'required|email',
            'address_index'     => 'required|digits:6',
            'address_city'      => 'required',
            'address_street'    => 'required',
            'address_home'      => 'required|numeric',
            'address_block'     => 'nullable|alpha',
            'address_porch'     => 'nullable|numeric',
            'address_apartment' => 'nullable|numeric',
            'comment'           => 'nullable',
        ]);


        $address = "Телефон: $validatedData[phone],\n";
        $address = "Индекс: $validatedData[address_index],\n";
        $address .= "г./ н.п.: $validatedData[address_city],\n";
        $address .= "пр./ ул./ пер.: $validatedData[address_street],\n";
        $address .= "д.: $validatedData[address_home],\n";
        $address .= "стр.: " . ($validatedData['address_block'] ?? "-") . ",\n";
        $address .= "п.: " . ($validatedData['address_porch'] ?? "-") . ",\n";
        $address .= "кв.: " . ($validatedData['address_apartment'] ?? "-");


        // If user authorized save user data
        if (Auth::user()) {
            $user = Auth::user();
            $user->surname = $request->input('surname');
            $user->name = $request->input('name');
            $user->patronymic = $request->input('patronymic');
            $user->phone = $request->input('phone');
            $user->address_index = $request->input('address_index');
            $user->address_city = $request->input('address_city');
            $user->address_street = $request->input('address_street');
            $user->address_home = $request->input('address_home');
            $user->address_block = $request->input('address_block');
            $user->address_porch = $request->input('address_porch');
            $user->address_apartment = $request->input('address_apartment');
            $user->saveOrFail();
        }

        $fullName = trim(implode(' ', [
            $request->input('surname'),
            $request->input('name'),
            $request->input('patronymic'),
        ]));


        // Create new order
        $order = new Order();
        $order->status = Order::STATUS_NEW;
        $order->full_name = $fullName;
        $order->phone = $validatedData['phone'];
        $order->email = $validatedData['email'];
        $order->address = $address;
        $order->comment = $validatedData['comment'];

        // Attach order to user if authorized
        if (Auth::user()) {
            $order->user()->associate(Auth::user());
        }

        // Counting products total
        $products = collect(ShoppingCartService::getItems());
        $order->total = $products->sum('sum');
        $order->saveOrFail();

        // Attach shopping cart items to order
        $productIdsWithCountAndPrice = $products->mapWithKeys(function ($item, $key) {
            return [
                $item['id'] => [
                    'count' => (int)$item['count'],
                    'price' => (float)$item['price'],
                ],
            ];
        })->toArray();
        $order->products()->attach($productIdsWithCountAndPrice);

        // Send mail
        Mail::send(new OrderCreated($order));

        // Clear shopping cart
        ShoppingCartService::flush();

        return redirect()->route('order.show', ['order' => $order->id]);
    }
}
