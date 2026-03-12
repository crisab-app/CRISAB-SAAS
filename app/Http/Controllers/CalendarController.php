<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\ServiceTemplate;
use App\Models\User;
use App\Models\EventItem;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $events = auth()->user()->contract->events()
            ->where(function($query) {
                $query->where('visibility', 'public')
                      ->orWhere(function($q) {
                          $q->where('visibility', 'private')->where('user_id', auth()->id());
                      });
            })
            ->get(['id', 'title', 'start', 'end', 'color'])
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'color' => $event->color,
                    'url' => route('calendario.show', $event->id) 
                ];
            });

        return view('calendario.index', compact('events'));
    }

    public function create()
    {
        $templates = ServiceTemplate::where('contract_id', auth()->user()->contract_id)->get();
        $users = User::all(); 
        return view('calendario.create', compact('templates', 'users')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'visibility' => 'required|in:public,private',
            'template_id' => 'nullable|exists:service_templates,id',
            'preaching_topic' => 'nullable|string|max:255',
            'liturgy_details' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $event = auth()->user()->contract->events()->create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'color' => $request->color ?? '#3b82f6',
            'visibility' => $request->visibility,
            'preaching_topic' => $request->preaching_topic,
            'liturgy_details' => $request->liturgy_details,
            'user_id' => auth()->id(),
            'status' => 'draft'
        ]);

        if ($request->filled('template_id')) {
            $template = ServiceTemplate::with('items')->find($request->template_id);
            if ($template) {
                foreach ($template->items as $item) {
                    $event->items()->create([
                        'name'        => $item->name,         // El nombre del bloque (Bienvenida, Himno, etc)
                        'skill_id'    => $item->skill_id,     // El privilegio requerido
                        'order_index' => $item->order_index,  // El orden
            ]);
                }
            }
        }

        return redirect()->route('calendario')->with('success', 'Evento creado exitosamente.');
    }

    public function show(Event $event)
    {
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403);
        }

        $event->load('items.skill', 'items.user');
        $users = User::where('contract_id', auth()->user()->contract_id)->get();

        $hymns = \App\Models\Hymn::orderBy('number')->get();
        
        return view('calendario.show', compact('event', 'users', 'hymns'));
    }

    public function assignItem(Request $request, EventItem $item)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'details' => 'nullable|string'
        ]);

        $item->update([
            'user_id' => $request->user_id,
            'details' => $request->details
        ]);

        return back()->with('success', 'Participación actualizada.');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'visibility' => 'required|in:public,private',
        ]);

        $event->update($request->all());

        return redirect()->route('calendario.show', $event->id)->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('calendario')->with('success', 'Evento eliminado.');
    }

    public function closeEvent(Event $event)
    {
        $event->update(['status' => 'closed']);
        return back()->with('success', 'Evento cerrado.');
    }
    // 10. Guardar el bosquejo de predicación (TinyMCE)
    public function updateSermon(Request $request, Event $event)
    {
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para modificar este evento.');
        }

        $request->validate([
            'sermon_notes' => 'nullable|string',
            'preaching_topic' => 'nullable|string|max:255'
        ]);

        $event->update([
            'sermon_notes' => $request->sermon_notes,
            'preaching_topic' => $request->preaching_topic
        ]);

        return back()->with('success', '¡Bosquejo de predicación guardado con éxito!');
    }
}