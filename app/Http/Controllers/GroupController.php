<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // Listar los grupos de MI iglesia
    public function index()
    {
        if (!auth()->user()->contract) {
            abort(403, 'No tienes una iglesia asignada.');
        }

        $groups = auth()->user()->contract->groups;
        return view('groups.index', compact('groups'));
    }

    // Mostrar formulario para crear grupo
    public function create()
    {
        return view('groups.create');
    }

    // Guardar el nuevo grupo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'has_sales' => 'required|boolean', // Validamos que envíe 1 o 0
        ]);

        // Crear el grupo vinculado automáticamente a la iglesia del usuario
        auth()->user()->contract->groups()->create([
            'name' => $request->name,
            'description' => $request->description,
            'has_sales' => $request->has_sales, // Guardamos la configuración de la tiendita
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    // Ver los detalles y la directiva del grupo
    public function show(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para ver este grupo.');
        }

        $group->load('members');
        $users = auth()->user()->contract->users;

        return view('groups.show', compact('group', 'users'));
    }
    
    // Asignar un cargo
    public function assignMember(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string',
        ]);

        $group->members()->detach($request->user_id);
        $group->members()->attach($request->user_id, ['role' => $request->role]);

        return back()->with('success', 'Cargo asignado correctamente.');
    }
    
    // Quitar a alguien de la directiva
    public function removeMember(Group $group, User $user)
    {
        $group->members()->detach($user->id);
        return back()->with('success', 'Miembro removido del grupo.');
    }

    // Eliminar un grupo por completo
    public function destroy(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para eliminar este grupo.');
        }

        $group->delete();

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
    }
}