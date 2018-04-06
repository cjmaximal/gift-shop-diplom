<?php

namespace App\Http\Middleware;

use App\Order;
use Closure;

class CheckOrderHash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if (\Auth::check()) {
            $id = \Route::current()->parameter('id');
            $order = Order::query()->where('user_id', \Auth::user()->id)->where('id', $id)->first();

            if (!$order) {
                return redirect()->route('home.index');
            }

            return $next($request);
        }

        if ($request->filled('hash') == false || $request->filled('email' == false)) {
            return redirect()->route('home.index');
        }
        $order = Order::query()->where('email', $request->input('email'))->first();
        $hash = md5(optional($order)->id . ':' . optional($order)->email);
        if ($hash != $request->input('hash')) {
            return redirect()->route('home.index');
        }

        return redirect()->route('profile.index');
    }
}
