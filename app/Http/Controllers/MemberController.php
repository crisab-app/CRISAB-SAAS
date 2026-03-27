<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\Contract;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // 1. Mostrar la lista de todos los miembros de ESTA iglesia con sus privilegios
    public function index()
    {
        // Traemos los usuarios con sus skills cargadas para que los contadores sean rápidos
        $members = User::where('contract_id', auth()->user()->contract_id)
                       ->with('skills')
                       ->get();

        return view('miembros.index', compact('members'));
    }

    // 2. Mostrar el formulario para dar de alta (Interno)
    public function create()
    {
        $skills = Skill::all(); 
        return view('miembros.create', compact('skills'));
    }

    // 3. Guardar el nuevo miembro (Interno)
    public function store(Request $request)
    {
        // Validamos: Agregamos las reglas para el bautismo
        $request->validate([
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'nationality' => 'required|string|max:255',
            'curp' => 'required_if:nationality,México|nullable|string|max:18|unique:users,curp',
            'is_baptized' => 'nullable|boolean', // Agregado
            'baptism_date' => 'nullable|date', // Agregado
            'profile_photo' => 'nullable|image|max:2048', 
            'id_front' => 'nullable|image|max:2048',
            'id_back' => 'nullable|image|max:2048',
        ]);

        $profilePath = $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('kyc/profiles', 'public') : null;
        $idFrontPath = $request->hasFile('id_front') ? $request->file('id_front')->store('kyc/documents', 'public') : null;
        $idBackPath = $request->hasFile('id_back') ? $request->file('id_back')->store('kyc/documents', 'public') : null;

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'contract_id' => auth()->user()->contract_id,
            'paternal_surname' => $request->paternal_surname,
            'maternal_surname' => $request->maternal_surname,
            'marital_status' => $request->marital_status,
            'birthdate' => $request->birthdate,
            'nationality' => $request->nationality,
            'curp' => mb_strtoupper($request->curp),
            'is_baptized' => $request->has('is_baptized'), // Devuelve true/false mágicamente
            'baptism_date' => $request->has('is_baptized') ? $request->baptism_date : null, // Solo guarda la fecha si marcó la casilla
            'profile_photo_path' => $profilePath,
            'id_front_path' => $idFrontPath,
            'id_back_path' => $idBackPath,
        ]);

        if ($request->has('skills')) {
            $user->skills()->attach($request->skills);
        }

        return redirect()->route('miembros.index')->with('success', 'Miembro registrado correctamente.');
    }

    // 4. Mostrar el formulario para EDITAR
    public function edit(User $miembro)
    {
        if ($miembro->contract_id !== auth()->user()->contract_id) {
            abort(403);
        }

        $skills = Skill::all();
        $memberSkills = $miembro->skills->pluck('id')->toArray();

        return view('miembros.edit', compact('miembro', 'skills', 'memberSkills'));
    }

    // 5. Procesar la actualización
    public function update(Request $request, User $miembro)
    {
        if ($miembro->contract_id !== auth()->user()->contract_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $miembro->id,
            'email' => 'nullable|email|unique:users,email,' . $miembro->id,
            'birthdate' => 'required|date',
            'nationality' => 'required|string',
            'curp' => 'required_if:nationality,México|nullable|string|max:18',
            'is_baptized' => 'nullable|boolean', // Agregado
            'baptism_date' => 'nullable|date', // Agregado
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $miembro->fill($request->only([
            'name', 'paternal_surname', 'maternal_surname', 
            'phone', 'email', 
            'birthdate', 'nationality', 'curp', 'marital_status'
        ]));

        // Lógica de actualización para el bautismo
        $miembro->is_baptized = $request->has('is_baptized');
        $miembro->baptism_date = $request->has('is_baptized') ? $request->baptism_date : null;

        if ($request->hasFile('profile_photo')) {
            $miembro->profile_photo_path = $request->file('profile_photo')->store('kyc/profiles', 'public');
        }
        if ($request->hasFile('id_front')) {
            $miembro->id_front_path = $request->file('id_front')->store('kyc/documents', 'public');
        }
        if ($request->hasFile('id_back')) {
            $miembro->id_back_path = $request->file('id_back')->store('kyc/documents', 'public');
        }

        $miembro->save();
        $miembro->skills()->sync($request->skills ?? []);

        return redirect()->route('miembros.index')->with('success', 'Expediente actualizado correctamente.');
    }

    // 6. Procesar la BAJA
    public function destroy(User $miembro)
    {
        if ($miembro->contract_id !== auth()->user()->contract_id) {
            abort(403);
        }

        $miembro->delete();
        return redirect()->route('miembros.index')->with('success', 'El miembro ha sido dado de baja.');
    }

    // --- FUNCIONES PARA EL LINK PÚBLICO (POR ID) ---

    // 7. Mostrar formulario público de invitación usando ID
    public function publicRegistration($contract_id)
    {
        $iglesia = Contract::findOrFail($contract_id);
        return view('miembros.public_create', compact('iglesia'));
    }

    // 8. Guardar registro desde link público usando ID
    public function storePublic(Request $request, $contract_id)
    {
        $iglesia = Contract::findOrFail($contract_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6|confirmed', 
            'birthdate' => 'required|date',
            'gender' => 'required|string|in:Masculino,Femenino', 
            'nationality' => 'required|string',
            'curp' => 'required_if:nationality,México|nullable|string|max:18|unique:users,curp',
            'is_baptized' => 'nullable|boolean', // Agregado
            'baptism_date' => 'nullable|date', // Agregado
            'profile_photo' => 'nullable|image|max:2048', 
            'id_front' => 'nullable|image|max:2048',
            'id_back' => 'nullable|image|max:2048',
        ]);

        $profilePath = $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('kyc/profiles', 'public') : null;
        $idFrontPath = $request->hasFile('id_front') ? $request->file('id_front')->store('kyc/documents', 'public') : null;
        $idBackPath = $request->hasFile('id_back') ? $request->file('id_back')->store('kyc/documents', 'public') : null;

        User::create([
            'name' => $request->name,
            'paternal_surname' => $request->paternal_surname,
            'maternal_surname' => $request->maternal_surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'contract_id' => $iglesia->id,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender, 
            'nationality' => $request->nationality,
            'curp' => mb_strtoupper($request->curp),
            'marital_status' => $request->marital_status,
            'is_baptized' => $request->has('is_baptized'), // Devuelve true/false
            'baptism_date' => $request->has('is_baptized') ? $request->baptism_date : null, // Solo guarda si marcó la casilla
            'profile_photo_path' => $profilePath,
            'id_front_path' => $idFrontPath,
            'id_back_path' => $idBackPath,
        ]);

        return redirect()->back()->with('success', '¡Registro completado! Tu líder revisará tu información pronto.');
    }

    // ==========================================
    // 9. ACTUALIZAR PRIVILEGIOS Y PERMISOS (RBAC)
    // ==========================================
    public function updatePermissions(Request $request, User $miembro)
    {
        if ($miembro->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para editar a este usuario.');
        }

        if ($request->has('permission_type')) {
            $field = $request->permission_type;
            $allowedPermissions = ['can_manage_finances', 'can_manage_members', 'can_manage_church'];
            
            if (in_array($field, $allowedPermissions)) {
                $miembro->$field = $request->has('status');
                $miembro->save();
            }
        } 
        else {
            $miembro->can_manage_finances = $request->has('can_manage_finances');
            $miembro->save();
        }

        return back()->with('success', 'Privilegios de sistema actualizados para ' . $miembro->name);
    }
}