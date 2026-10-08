<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'active')
            ->orderBy('start_date')
            ->get();

        return view('events.index', compact('events'));
    }
}
