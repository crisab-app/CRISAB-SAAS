<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\ServiceTemplate;

class CalendarController extends Controller
{
    // 1. Mostrar el calendario
    public function index()
    {
        // Traemos los eventos y les armamos su link para poder darles clic
        $events = auth()->user()->contract->events()->get(['id', 'title', 'start', 'end', 'color'])->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
                'url' => route('calendario.show', $event->id) // ¡Aquí está la magia del clic!
            ];
        });

        return view('calendario.index', compact('events'));
    }

    // 2. Mostrar la pantalla del formulario
    public function create()
    {
        // Buscamos las plantillas de esta iglesia para enviarlas al menú desplegable
        $templates = ServiceTemplate::where('contract_id', auth()->user()->contract_id)->get();
        
        return view('calendario.create', compact('templates')); 
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
            'color' => 'nullable|string',
            'template_id' => 'nullable|exists:service_templates,id' // El usuario puede o no elegir plantilla
        ]);
        $contract = auth()->user()->contract;
        // 1. Creamos el evento (¡Una sola vez!)
        $event = $contract->events()->create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'color' => $request->color,
            'user_id' => auth()->id(), // <-- Esta es la línea clave
        ]);

        // 2. LA MAGIA: Si eligió una plantilla, copiamos sus bloques al evento
        if ($request->filled('template_id')) {
            // Buscamos la plantilla con sus bloques originales
            $template = ServiceTemplate::with('items')->find($request->template_id);
            
            if ($template) {
                // Recorremos cada bloque y lo clonamos para este evento específico
                foreach ($template->items as $item) {
                    $event->items()->create([
                        'name' => $item->name,
                        'skill_id' => $item->skill_id,
                        'order_index' => $item->order_index,
                        // user_id queda en blanco automáticamente para que asignes a la persona después
                    ]);
                }
            }
        }

        // Lo regresamos al calendario
        return redirect()->route('calendario')->with('success', 'Evento creado exitosamente con su liturgia.');
    }
    // 4. Mostrar los detalles de un evento específico y su liturgia
    public function show(Event $event)
    {
        // Validamos que el evento pertenezca a la iglesia del usuario actual
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para ver este evento.');
        }

        // Cargamos los bloques del evento y la información de la habilidad que requieren
        $event->load('items.skill', 'items.user');

        // Traemos a todos los usuarios de la iglesia CON sus habilidades/privilegios
        $users = \App\Models\User::with('skills')->where('contract_id', auth()->user()->contract_id)->get();
        return view('calendario.show', compact('event', 'users'));
    }
    // 5. Asignar una persona a un bloque de la liturgia
    // 5. Asignar una persona y sus detalles a un bloque de la liturgia
    public function assignItem(Request $request, \App\Models\EventItem $item)
    {
        if ($item->event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para modificar este evento.');
        }

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'details' => 'nullable|string' // Sin límite de tamaño
        ]);

        $item->update([
            'user_id' => $request->user_id,
            'details' => $request->details
        ]);

        return back()->with('success', 'Participación actualizada correctamente.');
    }
    // 6. Eliminar el evento por completo
    public function destroy(Event $event)
    {
        // Validamos que nadie de otra iglesia intente borrar tu evento
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para eliminar este evento.');
        }

        // Borramos el evento. (Los bloques de la liturgia se borrarán automáticamente
        // gracias al 'cascadeOnDelete' que pusimos en la migración).
        $event->delete();

        return redirect()->route('calendario')->with('success', 'Evento eliminado correctamente.');
    }
    // 7. Mostrar la pantalla para editar un evento
    public function edit(Event $event)
    {
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para editar este evento.');
        }
        return view('calendario.edit', compact('event'));
    }

    // 8. Guardar los cambios del evento editado
    public function update(Request $request, Event $event)
    {
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para actualizar este evento.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        // Actualizamos los datos básicos del evento
        $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('calendario.show', $event->id)->with('success', 'Evento actualizado correctamente.');
    }
    // 9. Cerrar un evento para que ya no se pueda editar su liturgia
    public function closeEvent(Event $event)
    {
        if ($event->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para modificar este evento.');
        }

        $event->update(['status' => 'closed']);

        return back()->with('success', '¡Evento cerrado! La liturgia ha sido bloqueada y ya no se puede modificar.');
    }
}