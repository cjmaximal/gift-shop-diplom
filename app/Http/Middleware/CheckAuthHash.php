<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckAuthHash
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
            return $next($request);
        }

        if ($request->filled('hash') == false || $request->filled('email' == false)) {
            return redirect()->route('login');
        }

        $user = User::query()->where('email', $request->input('email'))->first();
        $hash = md5(optional($user)->id . ':' . optional($user)->email);

        if ($hash != $request->input('hash')) {
            return redirect()->route('login');
        }

        \Auth::loginUsingId($user->id, true);

        return redirect()->route('profile.index');
    }
}
