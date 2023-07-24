<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()==true){
            if(Auth::user()->role == 'super-admin'){
                return $next($request);
            }
            elseif(Auth::user()->role == 'user'){
              return redirect()->route('dashboard');
            }
            elseif(Auth::user()->role == 'vendor'){
                return redirect()->route('vendor.dashboard');
            }
        }
    }
}
