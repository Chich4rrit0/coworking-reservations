<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $reservations = Reservation::with(['user', 'room'])->latest()->get();
        } else {
            $reservations = Auth::user()->reservations()->with('room')->latest()->get();
        }
        
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('reservations.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $startTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $endTime = (clone $startTime)->addHour();

        $room = Room::findOrFail($validated['room_id']);

        if (!$room->isAvailable($startTime)) {
            return back()->withErrors(['time' => 'La sala no está disponible en el horario seleccionado.'])->withInput();
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reserva creada exitosamente. Está pendiente de aprobación.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Update the status of the reservation.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $this->authorize('updateStatus', $reservation);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Estado de la reserva actualizado exitosamente.');
    }

    /**
     * Filter reservations by room.
     */
    public function filterByRoom(Request $request)
    {
        $this->authorize('viewAny', Reservation::class);
        
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $reservations = $room->reservations()->with('user')->latest()->get();
        $rooms = Room::all();

        return view('reservations.index', compact('reservations', 'rooms', 'room'));
    }
}