<?php

namespace App\Http\Controllers;

use App\Models\BibleVerse;
use Illuminate\Http\Request;

class BibleController extends Controller
{
    public function getChapters(Request $request)
    {
        $chapters = BibleVerse::where('book_name', $request->book)
            ->select('chapter')
            ->distinct()
            ->orderBy('chapter')
            ->pluck('chapter');

        return response()->json($chapters);
    }

    public function getVerses(Request $request)
    {
        $verses = BibleVerse::where('book_name', $request->book)
            ->where('chapter', $request->chapter)
            ->select('verse')
            ->orderBy('verse')
            ->pluck('verse');

        return response()->json($verses);
    }

    // EL NUEVO CEREBRO: Ahora soporta rangos de versículos
    public function getText(Request $request)
    {
        $query = BibleVerse::where('book_name', $request->book)
            ->where('chapter', $request->chapter);

        // Si el usuario eligió un "Versículo Final"
        if ($request->has('verse_end') && $request->verse_end != '') {
            $verses = $query->whereBetween('verse', [$request->verse, $request->verse_end])->get();
            
            if ($verses->count() > 0) {
                // Juntamos todos los versículos y le ponemos su numerito chiquito a cada uno
                $text = $verses->map(function($v) { 
                    return '<sup style="color:#9ca3af; font-size:0.75em;">'.$v->verse.'</sup> '.$v->text; 
                })->implode(' ');

                return response()->json([
                    'reference' => "{$request->book} {$request->chapter}:{$request->verse}-{$request->verse_end}",
                    'text' => $text
                ]);
            }
        } 
        // Si solo eligió un versículo individual
        else {
            $verse = $query->where('verse', $request->verse)->first();
            if ($verse) {
                return response()->json([
                    'reference' => "{$verse->book_name} {$verse->chapter}:{$verse->verse}",
                    'text' => $verse->text
                ]);
            }
        }

        return response()->json(['error' => 'No encontrado'], 404);
    }
}