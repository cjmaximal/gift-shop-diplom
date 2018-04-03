<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth.hash', 'auth']);
    }

    public function index()
    {
        $user = \Auth::user();
        $orders = $user->orders->isNotEmpty()
            ? $user->orders->map(function (Order $order) {

                $items = $order->products->map(function (Product $product) {
                    return [
                        'name' => $product->name,
                        'link' => route('home.product.show', ['product' => $product]),
                    ];
                })->toArray();

                return [
                    'items'  => $items,
                    'total'  => number_format($order->total, 2, ',', ' '),
                    'status' => Order::getStatuses()[ $order->status ],
                    'date'   => $order->created_at->format('d.m.Y H:i'),
                    'link'   => route('order.show', ['id' => $order->id]),
                ];
            })->toArray()
            : [];

        return view('profile.index', [
            'user'   => $user,
            'orders' => $orders,
        ]);
    }

    public function editPersonal()
    {
        $user = \Auth::user();

        return view('profile.personal', [
            'user' => $user,
        ]);
    }

    public function updatePersonal(Request $request)
    {
        $validatedData = $request->validate([
            'surname'    => 'nullable|string|max:255',
            'name'       => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'phone'      => 'required|string|max:255',
        ]);

        $user = \Auth::user();
        $user->fill($validatedData);
        $user->saveOrFail();

        return redirect()->route('profile.index');
    }

    public function editAddress()
    {
        $user = \Auth::user();

        return view('profile.address', [
            'user' => $user,
        ]);
    }

    public function updateAddress(Request $request)
    {
        $validatedData = $request->validate([
            'surname'    => 'nullable|string|max:255',
            'name'       => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'phone'      => 'required|string|max:255',
        ]);

        $user = \Auth::user();
        $user->fill($validatedData);
        $user->saveOrFail();

        return redirect()->route('profile.index');
    }
}
