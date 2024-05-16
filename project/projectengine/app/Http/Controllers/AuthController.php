<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('userdashboard');
        }
        return view('auth.selectlogin');
    }

    /* public function login(Request $request)
    {
        $guard = $request->input('guard', 'web');

        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'employee':
                    return redirect()->route('employee.dashboard'); 
                case 'admin':
                    return redirect()->route('admin.dashboard');
                default:
                    return redirect()->route('user.dashboard');
            }
        }

        return view('auth.selectlogin', compact('guard'));
    } */


    /*  public function employeeLogin()
     {
         if (Auth::guard('employee')->check()) {
             return redirect()->route('employee.dashboard');
         }
         return view('auth.employee_login');
     }

     public function adminLogin()
     {
         if (Auth::guard('admin')->check()) {
             return redirect()->route('admin.dashboard');
         }
         return view('auth.admin_login');
     } */

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Spróbuj zalogować się jako admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        // Spróbuj zalogować się jako pracownik
        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect()->route('employee.dashboard');
        }

        // Spróbuj zalogować się jako użytkownik
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('userdashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('userdashboard');
    }
}
