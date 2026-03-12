<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.user', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
        ];

        // Add role-specific validation rules
        if ($request->role === 'admin') {
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['nisn'] = 'nullable|string|max:20';
        } else {
            // User role
            $rules['nisn'] = 'required|string|max:20|unique:users';
            $rules['email'] = 'nullable|string|email|max:255|unique:users';
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'role' => $request->role,
            'nisn' => $request->nisn,
        ];

        // Only include email and password if provided
        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        }
        
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        User::create($userData);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'nisn' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'nisn' => $request->nisn,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
}

public function destroy(User $user)
{
    if ($user->id === auth()->id()) {
        return redirect()->back()
            ->with('error', 'You cannot delete your own account');
    }

    $user->delete();

    return redirect()->route('user.index')
        ->with('success', 'User deleted successfully');
}
}