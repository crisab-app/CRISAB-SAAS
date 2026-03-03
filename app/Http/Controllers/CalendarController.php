<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    // 1. Mostrar el calendario
    public function index()
    {
        // Traemos los eventos de tu iglesia actual
        $events = auth()->user()->contract->events()->get(['id', 'title', 'start', 'end']);
        return view('calendario.index', compact('events'));
    }

    // 2. Mostrar la pantalla del formulario
    public function create()
    {
        return view('calendario.create'); 
    }

    // 3. Guardar el nuevo evento
    public function store(Request $request)
    {
        // Validamos que los datos vengan correctos
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable|string',
        ]);

        // Lo guardamos en la base de datos asociado a tu iglesia
        auth()->user()->contract->events()->create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
        ]);

        // Lo regresamos al calendario
        return redirect()->route('calendario')->with('success', 'Evento creado exitosamente.');
    }
}