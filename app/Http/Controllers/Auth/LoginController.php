<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function logout()
    {
        $role = Auth::user()->role_id;
        Auth::logout();
        if( $role < 5 ){
            return redirect()->route('center.login');
        }elseif ($role == 5){
            return redirect()->route('center.index');
        }
    }

    public function username()
    {
        return 'username';
    }

    protected function redirectTo()
    {
        if ( Auth::user()->role_id < 5){
            redirect()->route('center.index', Auth::user()->username);
        }
        if ( Auth::user()->role_id == 5){
            redirect()->route('account.index');
        }
    }
}
