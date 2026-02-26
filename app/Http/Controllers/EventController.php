<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User; // Aquí está la conexión con los usuarios
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
                'color' => $event->color ?? '#3b82f6',
            ];
        });

        return view('calendar', compact('events'));
    }

    public function create()
    {
        // Traemos todos los usuarios para llenar las listas desplegables
        $users = User::all();
        return view('events.create', compact('users'));
    }

    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'color' => 'nullable|string|max:7',
            'participants' => 'nullable|array', // Validamos los participantes
        ]);

        // 2. Guardamos el evento principal
        $event = Event::create([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'color' => $request->color ?? '#3b82f6',
            'user_id' => auth()->id(),
        ]);

        // 3. Guardamos a los encargados con sus roles
        if ($request->filled('participants')) {
            foreach ($request->participants as $role => $userId) {
                if (!empty($userId)) {
                    // Magia de Laravel: Conecta el evento con el usuario y le anota su rol
                    $event->participants()->attach($userId, ['role' => $role]);
                }
            }
        }

        return redirect()->route('calendario');
    }
}