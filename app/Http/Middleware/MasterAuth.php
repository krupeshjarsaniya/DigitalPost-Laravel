<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Helper;
use App\Menu;

class MasterAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->user_role == 1)
            {
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('login');

        }
        // return back();
        return redirect()->route('login');
        
    }
}
