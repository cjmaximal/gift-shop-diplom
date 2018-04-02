<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $ordersQ = Order::query()
            ->with('products');

        if ($request->filled('status')) {
            $ordersQ->where('status', $request->input('status'));
        }

        $orders = $ordersQ->orderBy('created_at', 'desc')->paginate($this->perPage);
        $statuses = Order::getStatuses();

        return view('admin.orders.index', [
            'orders'   => $orders,
            'statuses' => $statuses,
        ]);
    }

    public function edit($id)
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

        return view('admin.orders.edit', [
            'order' => $order,
            'items' => $items,
            'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::query()->findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|bool',
        ]);

    }

    public function destroy($id)
    {
        $order = Order::query()->findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with(['status' => "Заказ #$id успешно удален!"]);
    }
}
