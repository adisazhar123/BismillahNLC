<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminOnly
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
      if (Auth::user()) {
        if (Auth::user()->role == 1) {
          return $next($request);
        }
        if ($request->ajax()) {
          return response()->json(['intended_url'=>'/'], 401);
        }
        return redirect('/');
      }
      if ($request->ajax()) {
        return response()->json(['intended_url'=>'/'], 401);
      }
      return redirect('/');
    }
}
