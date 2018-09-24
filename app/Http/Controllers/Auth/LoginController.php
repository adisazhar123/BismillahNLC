<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Session;
use Input;
use Log;
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

    // protected function authenticated(){
    //   if(Auth::check()){
    //     User::find(Auth::id())->update(['session_token' => Session::getId()]);
    //     if (Auth::user()->role == 3){
    //       return response()->json(['intended_url'=>'/peserta/welcome-new']);
    //     }else if (Auth::user()->role == 2){
    //       return response()->json(['intended_url'=>'/admin/scoreboard']);
    //     }else {
    //       return response()->json(['intended_url'=>'/admin']);
    //     }
    //   }
    // }

    public function doLogin(){
      $userdata = array(
        'email'     => Input::get('email'),
        'password'  => Input::get('password')
      );

      try {
        // attempt to do the login
        if (Auth::attempt($userdata)) {
           User::find(Auth::id())->update(['session_token' => Session::getId()]);
           Log::info("User with email: " . Auth::user()->email ." is logged in!");
           if (Auth::user()->role == 3){
             return response()->json(['intended_url'=>'/peserta/home']);
           }else if (Auth::user()->role == 2){
             return response()->json(['intended_url'=>'/admin/scoreboard']);
           }else {
             return response()->json(['intended_url'=>'/admin']);
           }

         } else {
           Log::info("User with email: " . Input::get('email') ." tried to login with wrong credentials!");
           return response()->json('wrong credentials');
         }
      } catch (\Exception $e) {
        Log::emergency("Server error. Can't login, email: " . Input::get('email'). ", error: " . $e->getMessage());
        return response()->json("Server Error", 500);
      }


    }
}
