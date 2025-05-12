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
}