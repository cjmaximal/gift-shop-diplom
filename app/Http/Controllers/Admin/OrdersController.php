<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orders = Order::query()
            ->orderBy('created_at', 'desc')
            ->forPage($request->get('page', $this->page), $this->perPage)
            ->get();

        dd($orders);
    }
}
