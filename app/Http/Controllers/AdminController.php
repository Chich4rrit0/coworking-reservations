<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $roomsCount = Room::count();
        $reservationsCount = Reservation::count();
        $pendingReservationsCount = Reservation::where('status', 'pending')->count();
        $recentReservations = Reservation::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'roomsCount',
            'reservationsCount',
            'pendingReservationsCount',
            'recentReservations'
        ));
    }
}