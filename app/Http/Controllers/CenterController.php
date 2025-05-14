<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::with('leader', 'members')->get();
        return view('centers.index', compact('centers'));
    }

    public function create()
    {
        return view('centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|unique:centers,nickname|max:50',
        ]);

        Center::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
        ]);

        return redirect()->route('centers.index')->with('success', 'Center created successfully.');
    }

    public function assignLeader(Request $request, Center $center)
    {
        $request->validate([
            'leader_id' => 'required|exists:users,id',
        ]);

        $center->update(['leader_id' => $request->leader_id]);

        return redirect()->route('centers.index')->with('success', 'Leader assigned successfully.');
    }

    public function addMember(Request $request, Center $center)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        if (!$center->members->contains($request->user_id)) {
            $center->members()->attach($request->user_id);
        }

        return redirect()->route('centers.index')->with('success', 'Member added successfully.');
    }

    public function removeMember(Request $request, Center $center)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $center->members()->detach($request->user_id);

        // If the removed user was the leader, set leader_id to null
        if ($center->leader_id == $request->user_id) {
            $center->update(['leader_id' => null]);
        }

        return redirect()->route('centers.index')->with('success', 'Member removed successfully.');
    }
    public function details(Center $center)
    {
        $center->load('leader', 'members');
        return view('centers.details', compact('center'));
    }
}