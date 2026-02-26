<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Traemos todos los eventos y los preparamos para el calendario
        $events = Event::all()->map(function($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
            ];
        });

        return view('calendar', compact('events'));
    }
    public function create()
    {
        // Esto abrirá la pantalla del formulario
        return view('events.create');
    }

    public function store(Request $request)
    {
        // 1. Validamos que no falten datos importantes
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        // 2. Guardamos el evento en la base de datos
        Event::create([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => auth()->id(), // Automáticamente asigna a tu usuario como el creador
            // Por ahora dejamos el salón (room) vacío hasta que creemos los salones
        ]);

        // 3. Regresamos al calendario
        return redirect()->route('calendario');
    }
}