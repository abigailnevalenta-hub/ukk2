<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        if ($request->filled('email')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {

                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }

            return back()->withErrors([
                'email' => 'Email atau password admin salah'
            ]);
        }
        if ($request->filled('nisn')) {

            $request->validate([
                'nisn' => 'required'
            ]);

            $user = User::where('nisn', $request->nisn)
                        ->where('role', 'user')
                        ->first();

            if ($user) {

                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->route('dashboardSiswa');
            }

            return back()->withErrors([
                'nisn' => 'NISN tidak ditemukan'
            ]);
        }

        return back()->withErrors([
            'login' => 'Data login tidak valid'
        ]);
    }   

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');
    }
}