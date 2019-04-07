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
        if ($role < 5) {
            return redirect()->route('center.login');
        } elseif ($role == 5) {
            return redirect()->route('account.index');
        }
    }

    public function username()
    {
        return 'username';
    }

    protected function redirectTo()
    {
        $role = Auth::user()->role_id;


        if ( $role == 1 ){
            redirect()->route('administrator.index', Auth::user()->username);
        }elseif ($role == 2){
            redirect()->route('center.index', Auth::user()->username);
        }elseif ($role == 3){
            redirect()->route('admin.index', Auth::user()->username);
        }elseif ($role == 4){
            dd("Trainer");
        }else{
            redirect()->route('account.index');
        }
    }
}
