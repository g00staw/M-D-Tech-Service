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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // Pobierz aktualnie zalogowanego użytkownika

            return redirect()->route('userdashboard')->with('user', $user); // Przekazanie użytkownika do widoku
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('userdashboard');
    }
}
