<?php

namespace App\Http\Controllers;

use App\Order;
use App\Services\ShoppingCartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        dd($order);
    }

    public function confirm()
    {
        return view('order.confirm', ['shoppingCartItems' => ShoppingCartService::getItems()]);
    }
}
