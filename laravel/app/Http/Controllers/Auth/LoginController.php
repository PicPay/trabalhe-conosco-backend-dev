<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        // show the form
        return view('login');
    }

    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        $request = new Request($user_data);

        $credentials = request(['email', 'password']);


        if(Auth::attempt($credentials))
        {
            return redirect('/dashboard');
        }
        else
        {
            return back()->with('error', 'Wrong Login Details');
        }

    }


    public function dashboard(){
        if (Auth::check()) {
            return view('dashboard', array('name'=> Auth::user()->api_token));
        }else{
            return redirect('/');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
