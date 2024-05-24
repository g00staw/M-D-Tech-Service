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

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Spróbuj zalogować się jako admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admindashboard');
        }

        // Spróbuj zalogować się jako pracownik
        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect()->route('employee-dashboard');
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
