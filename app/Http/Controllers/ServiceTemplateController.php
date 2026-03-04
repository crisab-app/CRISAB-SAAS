<?php

namespace App\Http\Controllers;

use App\Models\ServiceTemplate;
use App\Models\Skill;
use App\Models\ServiceItem;
use Illuminate\Http\Request;

class ServiceTemplateController extends Controller
{
    public function index()
    {
        $templates = ServiceTemplate::all();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        ServiceTemplate::create([
            'contract_id' => auth()->user()->contract_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('templates.index')->with('success', 'Plantilla creada con éxito.');
    }

    public function show(ServiceTemplate $template)
    {
        $skills = Skill::all(); 
        $template->load('items.skill'); 
        return view('templates.show', compact('template', 'skills'));
    }

    public function storeItem(Request $request, ServiceTemplate $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'skill_id' => 'required|exists:skills,id',
            'order_index' => 'required|integer'
        ]);

        $template->items()->create([
            'name' => $request->name,
            'skill_id' => $request->skill_id,
            'order_index' => $request->order_index,
        ]);

        return back()->with('success', 'Bloque añadido a la liturgia correctamente.');
    }

    public function destroy(ServiceTemplate $template)
    {
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Plantilla eliminada correctamente.');
    }

    public function destroyItem($id)
    {
        $item = \App\Models\ServiceItem::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Bloque eliminado del orden.');
    }

    public function moveUp($id)
    {
        $item = \App\Models\ServiceItem::findOrFail($id);
        $previousItem = \App\Models\ServiceItem::where('service_template_id', $item->service_template_id)
            ->where('order_index', '<', $item->order_index)
            ->orderBy('order_index', 'desc')
            ->first();

        if ($previousItem) {
            $temp = $item->order_index;
            $item->update(['order_index' => $previousItem->order_index]);
            $previousItem->update(['order_index' => $temp]);
        }
        return back();
    }

    public function moveDown($id)
    {
        $item = \App\Models\ServiceItem::findOrFail($id);
        $nextItem = \App\Models\ServiceItem::where('service_template_id', $item->service_template_id)
            ->where('order_index', '>', $item->order_index)
            ->orderBy('order_index', 'asc')
            ->first();

        if ($nextItem) {
            $temp = $item->order_index;
            $item->update(['order_index' => $nextItem->order_index]);
            $nextItem->update(['order_index' => $temp]);
        }
        return back();
    }
}