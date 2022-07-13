<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\DistributorChannel;

class DistributorAuth
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

        if(Auth::check()) {
            $user = Auth::user();
            $distributor = DistributorChannel::where('user_id', $user->id)->first();
            if(empty($distributor)) {
                Auth::logout();
                return redirect()->route('distributors.loginForm');
            }
            else {
                return $next($request);
            }
        }
        else {
            Auth::logout();
            return redirect()->route('distributors.loginForm');
        }

    }
}
