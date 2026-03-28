<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
                // Soportamos ambos nombres de columna por seguridad
                $start = $event->start_time ?? $event->start;
                $end = $event->end_time ?? $event->end;

                return [
                    'title' => $event->title,
                    'start' => $start ? \Carbon\Carbon::parse($start)->toIso8601String() : now()->toIso8601String(),
                    'end' => $end ? \Carbon\Carbon::parse($end)->toIso8601String() : now()->addHours(2)->toIso8601String(),
                    'color' => $event->color ?? '#3b82f6',
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
        // 1. Validamos usando los nombres que vengan del formulario (start o start_time)
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
            'visibility' => 'required|in:public,private',
            'preaching_topic' => 'nullable|string|max:255',
            'liturgy_details' => 'nullable|string',
            'participants' => 'nullable|array', 
        ]);

        // Atrapamos las fechas sin importar cómo se llamen en el formulario HTML
        $startTime = $request->start_time ?? $request->start;
        $endTime = $request->end_time ?? $request->end;

        // 2. Guardamos el evento
        $event = Event::create([
            'title' => $request->title,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'color' => $request->color ?? '#3b82f6',
            'visibility' => $request->visibility,
            'preaching_topic' => $request->preaching_topic,
            'liturgy_details' => $request->liturgy_details,
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

        return redirect()->route('calendario')->with('success', 'Evento programado exitosamente.');
    }

    public function updateSermon(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $event->update([
            'preaching_topic' => $request->preaching_topic,
            'bible_reading'   => $request->bible_reading,
            'sermon_notes'    => $request->sermon_notes,
        ]);

        return redirect()->back()->with('success', 'Bosquejo y lectura guardados correctamente.');
    }

    // ==========================================
    // 🖨️ EXPORTAR PDF (CON MAGIA DE ZONAS HORARIAS)
    // ==========================================
    public function exportPdf($id)
    {
        // 1. Buscamos el evento
        $event = Event::with('items')->findOrFail($id);
        
        // 2. Extraemos la zona horaria de ESTA iglesia específica (o usamos Cancún si es vieja)
        $timezone = auth()->user()->contract->timezone ?? 'America/Cancun';

        // 3. Buscamos las fechas asegurándonos de agarrar la columna correcta
        $rawStart = $event->start_time ?? $event->start ?? $event->date;
        $rawEnd = $event->end_time ?? $event->end ?? $event->date;

        // 4. Convertimos la fecha a la zona horaria de la iglesia y le damos formato bonito AQUÍ
        $startFormatted = $rawStart ? \Carbon\Carbon::parse($rawStart)->timezone($timezone)->format('d/m/Y h:i A') : 'Hora no definida';
        $endFormatted = $rawEnd ? \Carbon\Carbon::parse($rawEnd)->timezone($timezone)->format('d/m/Y h:i A') : 'Hora no definida';

        // 5. Generamos el PDF pasándole las fechas ya procesadas como texto
        $pdf = Pdf::loadView('calendario.pdf', [
            'event' => $event,
            'startFormatted' => $startFormatted,
            'endFormatted' => $endFormatted
        ]);
        
        return $pdf->download('Liturgia - ' . $event->title . '.pdf');
    }
}