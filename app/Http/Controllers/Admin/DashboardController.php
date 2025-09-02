<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Executive;
use App\Models\Gallery;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
            'total_galleries' => Gallery::count(),
            'total_executives' => Executive::count(),
            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::pending()->count(),
        ];

        $recentEvents = Event::latest()->take(5)->get();
        $recentRegistrations = Registration::latest()->take(10)->get();

        return view('admin.dashboard.index', compact('stats', 'recentEvents', 'recentRegistrations'));
    }
}
