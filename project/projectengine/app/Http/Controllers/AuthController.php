<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


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


        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admindashboard');
        }

        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect()->route('employeedashboard');
        }

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

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $messages = [
            'password.regex' => 'Hasło musi mieć co najmniej 8 znaków i zawierać co najmniej jedną cyfrę.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9]).{8,}$/',
            ],
        ], $messages);

        if (
            User::where('email', $request->email)->exists() ||
            Admin::where('email', $request->email)->exists() ||
            Employee::where('email', $request->email)->exists()
        ) {
            return back()->with('error', 'Email jest w użyciu.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Zarejestrowano pomyślnie.');
    }


}
