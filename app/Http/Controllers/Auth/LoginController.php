<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLogin()
    {
        return abort(404);
    }

    public function showLogout()
    {
        return abort(404);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')){
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login!');
        }

        elseif ($user->hasRole('auditee')){
            return redirect()->route('auditee.dashboard')->with('success', 'Berhasil Login!');
        }

        elseif ($user->hasRole('auditor')){
            return redirect()->route('auditor.dashboard')->with('success', 'Berhasil Login!');
        }

        elseif ($user->hasRole('ketua')){
            return redirect()->route('ketua.dashboard')->with('success', 'Berhasil Login!');
        }

        return redirect()->route('home')->with('error', 'Login Gagal');
    }

}
