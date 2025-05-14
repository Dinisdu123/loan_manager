<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('profiles.index', compact('users'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_number' => 'required|string|unique:users,user_number|max:15',
            'nic' => 'required|string|unique:users,nic|max:15',
            'phone' => 'required|string|unique:users,phone|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_number' => 'required|string|max:255|unique:users,user_number,' . $user->id,
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('centers.details', $user->centers->first()->id)
                         ->with('success', 'User updated successfully.');
    }
}