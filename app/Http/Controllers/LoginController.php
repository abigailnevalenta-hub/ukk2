<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        // Validate the login input
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if(\Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->route('login.page')->withErrors(['email' => 'Invalid credentials']);
    }
}
