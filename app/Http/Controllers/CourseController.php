<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // 1. Mostrar Catálogo de Cursos
    public function index()
    {
        $courses = Course::where('contract_id', auth()->user()->contract_id)
                         ->with('teacher')
                         ->withCount('students')
                         ->get();

        return view('courses.index', compact('courses'));
    }

    // 2. Mostrar Formulario de Nuevo Curso
    public function create()
    {
        $members = User::where('contract_id', auth()->user()->contract_id)->get();
        return view('courses.create', compact('members'));
    }

    // 3. GUARDAR EL CURSO EN LA BASE DE DATOS (¡Aquí estaba el error!)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
            'schedule' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Course::create([
            'contract_id' => auth()->user()->contract_id,
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
            'schedule' => $request->schedule,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }

// 4. Mostrar el Aula Virtual (Detalles del curso y sus alumnos)
    public function show(Course $curso)
    {
        // Usamos != en lugar de !== para evitar problemas de formato de texto/número
        if ($curso->contract_id != auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para ver este curso.');
        }

        $curso->load('students', 'teacher');

        $enrolledStudentIds = $curso->students->pluck('id')->toArray();
        $availableMembers = User::where('contract_id', auth()->user()->contract_id)
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->get();

        return view('courses.show', compact('curso', 'availableMembers'));
    }

    // 5. Inscribir a un Discípulo en el Aula
    public function enroll(Request $request, Course $curso)
    {
        if ($curso->contract_id != auth()->user()->contract_id) {
            abort(403);
        }

        $request->validate(['user_id' => 'required|exists:users,id']);

        $curso->students()->syncWithoutDetaching([
            $request->user_id => [
                'status' => 'enrolled', 
                'enrollment_date' => now()
            ]
        ]);

        return back()->with('success', 'Discípulo inscrito correctamente en el aula.');
    }

    // 6. Actualizar estado del alumno (Ej. Graduarlo)
    public function updateStudentStatus(Request $request, Course $curso, User $student)
    {
        if ($curso->contract_id != auth()->user()->contract_id) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:enrolled,graduated,dropped']);

        $completionDate = $request->status === 'graduated' ? now() : null;

        $curso->students()->updateExistingPivot($student->id, [
            'status' => $request->status,
            'completion_date' => $completionDate
        ]);

        return back()->with('success', 'Estado del discípulo actualizado.');
    }
    // 7. Borrar un curso
    public function destroy(Course $curso)
    {
        // Validamos que sea el dueño
        if ($curso->contract_id != auth()->user()->contract_id) {
            abort(403);
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
}