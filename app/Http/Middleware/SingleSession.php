<?php

namespace App\Http\Middleware;

use Auth;
use Session;
use Closure;

class SingleSession
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
      if (Auth::check()) {
        if (Auth::user()->session_token != Session::getId()) {
          Auth::logout();
          if ($request->ajax()) {
            return response()->json(['intended_url'=>'/']);
          }
          return redirect('/');
        }
        return $next($request);
      }
      if ($request->ajax()) {
        return response()->json(['intended_url'=>'/'], 401);
      }
      return redirect('/');
    }
}
