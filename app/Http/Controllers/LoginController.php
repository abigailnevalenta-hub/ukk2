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

        // For now, we'll just redirect to dashboard
        // In a real application, you would verify credentials against the database
        return redirect()->route('dashboard');
    }
}
