<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        // Traemos los eventos públicos de la iglesia + los privados del usuario actual
        $events = Event::where('visibility', 'public')
            ->orWhere(function($query) {
                $query->where('visibility', 'private')
                      ->where('user_id', Auth::id());
            })
            ->get()
            ->map(function($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start_time->toIso8601String(),
                    'end' => $event->end_time->toIso8601String(),
                    'color' => $event->color ?? '#3b82f6',
                    // Podemos mandar datos extra al calendario si lo necesitamos
                    'description' => $event->preaching_topic ?? '', 
                ];
            });

        return view('calendar', compact('events'));
    }

    public function create()
    {
        // Traemos a todos los usuarios de la iglesia actual para asignar roles
        $users = User::all();
        return view('events.create', compact('users'));
    }

    public function store(Request $request)
    {
        // 1. Validamos todos los datos, incluyendo los nuevos de liturgia y privacidad
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'color' => 'nullable|string|max:7',
            'visibility' => 'required|in:public,private', // Privacidad
            'preaching_topic' => 'nullable|string|max:255', // Tema sermón
            'liturgy_details' => 'nullable|string', // Cantos/Lecturas
            'participants' => 'nullable|array', 
        ]);

        // 2. Guardamos el evento
        $event = Event::create([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'color' => $request->color ?? '#3b82f6',
            'visibility' => $request->visibility,
            'preaching_topic' => $request->preaching_topic,
            'liturgy_details' => $request->liturgy_details,
            // attendance_count se queda en 0 por defecto al crear
            'user_id' => Auth::id(),
        ]);

        // 3. Guardamos a los encargados con sus roles
        if ($request->filled('participants')) {
            foreach ($request->participants as $role => $userId) {
                if (!empty($userId)) {
                    $event->participants()->attach($userId, ['role' => $role]);
                }
            }
        }

        // Te redirige al calendario usando el nombre de ruta que ya tenías
        return redirect()->route('calendario')->with('success', 'Evento programado exitosamente.');
    }
}