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
        if ($request->filled('hash') == false || $request->filled('email' == false)) {
            return redirect()->route('home.index');
        }

        if (\Auth::check()) {
            return $next($request);
        }


        $order = Order::query()->where('email', $request->input('email'))->first();
        $hash = md5(optional($order)->id . ':' . optional($order)->email);
        if ($hash != $request->input('hash')) {
            return redirect()->route('home.index');
        }

        return redirect()->route('profile.index');
    }
}
