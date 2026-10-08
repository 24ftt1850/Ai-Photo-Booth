<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::where('status', 'active')
            ->orderBy('start_date')
            ->get();

        return view('events.index', compact('events'));
    }
}
