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
}