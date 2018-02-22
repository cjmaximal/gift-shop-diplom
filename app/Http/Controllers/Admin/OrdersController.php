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

        if (session()->has('admin.order.perPage')) {
            $this->perPage = session()->get('admin.order.perPage', $this->perPage);
        } else {
            session('admin.order.perPage', $this->perPage);
        }
    }

    public function index(Request $request)
    {
        $orders = Order::all()->forPage($request->get('page', $this->page), $this->perPage);

        dd($orders);
    }
}
