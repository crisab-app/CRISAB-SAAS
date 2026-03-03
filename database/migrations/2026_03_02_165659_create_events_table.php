<?php

namespace App\Http\Controllers;

use App\Models\ServiceTemplate;
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

        ServiceTemplate::create($request->all());

        return redirect()->route('templates.index')->with('success', 'Plantilla creada.');
    }
}