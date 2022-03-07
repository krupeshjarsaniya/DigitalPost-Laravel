<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Helper;
use App\Menu;

class AdminAuth
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
            else {
                $route_name = \Request::route()->getName();
                $get_menu_id = Menu::where('route', $route_name)->first();
                if($get_menu_id) {
                    if(Helper::checkRoutePermission(Auth::user()->user_role, $get_menu_id->id)) {
                        return $next($request);
                    }
                    Auth::logout();
                    return redirect()->route('login');
                }
                return $next($request);
            }
            
        }
        // return back();
        return redirect()->route('login');
        
    }
}
