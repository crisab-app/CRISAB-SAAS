<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        if (!auth()->user()->contract) { abort(403); }
        $skills = auth()->user()->contract->skills;
        return view('skills.index', compact('skills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        auth()->user()->contract->skills()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('privilegios.index')->with('success', 'Privilegio creado.');
    }

    public function show(Skill $skill)
    {
        if ($skill->contract_id != auth()->user()->contract_id) { abort(403); }
        
        $skill->load('users');
        $users = auth()->user()->contract->users;

        return view('skills.show', compact('skill', 'users'));
    }

    public function assignUser(Request $request, Skill $skill)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        // syncWithoutDetaching asigna el don sin duplicarlo si ya lo tenía
        $skill->users()->syncWithoutDetaching([$request->user_id]);
        return back()->with('success', 'Privilegio asignado al hermano.');
    }

    public function removeUser(Skill $skill, User $user)
    {
        $skill->users()->detach($user->id);
        return back()->with('success', 'Privilegio removido.');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->contract_id != auth()->user()->contract_id) { abort(403); }
        $skill->delete();
        return redirect()->route('privilegios.index');
    }
}