<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Product;
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
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->forPage($request->get('page', $this->page), $this->perPage)
            ->get();

        $orders = $orders->isNotEmpty()
            ? $orders->map(function (Order $order) {

                $items = $order->products->map(function (Product $product) {
                    return [
                        'name' => $product->name,
                        'link' => route('home.product.show', ['product' => $product]),
                    ];
                })->toArray();

                return [
                    'id'     => $order->id,
                    'date'   => $order->created_at->format('d.m.Y H:i'),
                    'buyer'  => $order->full_name,
                    'items'  => $items,
                    'status' => Order::getStatuses()[$order->status],
                ];
            })->toArray()
            : [];


        $statuses = Order::getStatuses();

        return view('admin.orders.index', [
            'orders'   => $orders,
            'statuses' => $statuses,
        ]);
    }

    public function destroy($id)
    {
        $order = Order::query()->findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with(['status' => "Заказ #$id успешно удален!"]);
    }
}
