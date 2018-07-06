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
      return view('login');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user){
      if(Auth::check()){
        User::find(Auth::id())->update(['session_token' => Session::getId()]);
        if (Auth::user()->role == 3){
          return redirect()->route('peserta.home');
        }else{
          return "Admin";
        }
      }
    }

    // public function logout(Request $request){
    //   // $user = User::find(Auth::user()->id);
    //   // $user->is_online=0;
    //   // $user->save();
    //   // Auth::logout();
    //   // return redirect('/');
    // }
}
