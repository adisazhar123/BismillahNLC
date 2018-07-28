<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
      return view('index');
    }

    protected function authenticated(Request $request, $user){
      if(Auth::check()){
        User::find(Auth::id())->update(['session_token' => Session::getId()]);
        if (Auth::user()->role == 3){
          return response()->json(['intended_url'=>'/peserta/home']);
        }else{
          return response()->json(['intended_url'=>'/admin']);
        }
      }
    }
}
