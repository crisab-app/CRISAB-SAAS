<?php

namespace App\Http\Controllers;

use App\Models\LibraryItem;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryItem::whereNull('contract_id');

        // 🔍 Si el usuario buscó algo
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 🗂️ Si el usuario filtró por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->get();

        // Obtenemos las categorías únicas que existen en la BD para crear los botones
        $categories = LibraryItem::whereNull('contract_id')->pluck('category')->unique();

        return view('library.index', compact('items', 'categories'));
    }

    public function show(LibraryItem $biblioteca)
    {
        return view('library.show', compact('biblioteca'));
    }

    public function create()
    {
        if (!auth()->user()->is_super_admin) abort(403);
        return view('library.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_super_admin) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'type' => 'required|in:pdf,link,video',
            'category' => 'required|string', // <--- Validamos categoría
            'description' => 'nullable|string',
        ]);

        LibraryItem::create([
            'contract_id' => null,
            'title' => $request->title,
            'url' => $request->url,
            'type' => $request->type,
            'category' => $request->category, // <--- Guardamos categoría
            'description' => $request->description,
        ]);

        return redirect()->route('biblioteca.index')->with('success', 'Recurso guardado.');
    }

    public function destroy(LibraryItem $biblioteca)
    {
        if (!auth()->user()->is_super_admin) abort(403);
        $biblioteca->delete();
        return redirect()->route('biblioteca.index')->with('success', 'Recurso eliminado.');
    }
}