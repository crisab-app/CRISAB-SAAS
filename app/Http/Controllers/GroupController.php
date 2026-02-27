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
        // Si el usuario no tiene contrato, no mostramos nada (seguridad)
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
        ]);

        // Crear el grupo vinculado automáticamente a la iglesia del usuario
        auth()->user()->contract->groups()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    // Ver los detalles y la directiva del grupo
    public function show(Group $group)
    {
        // Usamos != (solo dos símbolos) en lugar de !==
        if ($group->contract_id != auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para ver este grupo.');
        }

        // Cargamos los miembros...

        // Cargamos los miembros con sus cargos
        $group->load('members');
        
        // Traemos a todos los usuarios de la iglesia para poder agregarlos a la directiva
        $users = auth()->user()->contract->users;

        return view('groups.show', compact('group', 'users'));
    }
    
    // Asignar un cargo (Presidente, Tesorero, etc.) a alguien
    public function assignMember(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string',
        ]);

        // Guardar o actualizar el cargo en la tabla puente
        // syncWithoutDetaching evita duplicados, pero aquí queremos permitir cambios
        // Usaremos attach para agregar, o updateExistingPivot si ya existe.
        // Para simplificar: Quitamos si ya estaba y lo volvemos a poner con el nuevo cargo
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
        // Usamos != en lugar de !==
        if ($group->contract_id != auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para eliminar este grupo.');
        }

        $group->delete();

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
    }
}