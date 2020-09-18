<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    public function authenticated($request, $user)
    {
        // account is not active
        if ($user->account_status == false)
        {
            $this->guard()->logout();
        }
        // has active account
        if ($user->account_status == true)
        {
            // but has no role
            if ($user->roles->count() == 0)
            {
                $this->guard()->logout();
            }
        }

        return redirect(url($this->redirectPath()));
    }

    public static function redirectTo(){
        
        // User role
        $role = Auth::user()->roles->first();

        if (!$role)
            return '/login'; 
        
        // Check user role
        switch ($role->name) {
            case 'admin':
                    return '/admin';
                break;
            case 'doctor':
                    return '/doctor';
                break; 
            case 'pharmacy':
                    return '/pharmacy';
                break; 
            case 'laboratory':
                    return '/laboratory';
                break; 
            case 'receptionist':
                    return '/reception';
                break; 
            case 'finance':
                    return '/finance';
                break; 
            case 'laboratory':
                    return '/lab';
                break; 
            default:
                    return '/login'; 
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
