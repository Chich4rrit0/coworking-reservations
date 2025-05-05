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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $reservations = Reservation::with(['user', 'room'])->latest()->get();
            $rooms = Room::all();
            return view('reservations.index', compact('reservations', 'rooms'));
        } else {
            $reservations = Auth::user()->reservations()->with('room')->latest()->get();
            return view('reservations.index', compact('reservations'));
        }
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
        // Solo permitir ver la reserva si es el propietario o un administrador
        if (Auth::user()->id !== $reservation->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'No tienes permiso para ver esta reserva.');
        }
        
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Update the status of the reservation.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        // Solo los administradores pueden cambiar el estado
        if (!Auth::user()->isAdmin()) {
            abort(403, 'No tienes permiso para cambiar el estado de esta reserva.');
        }
        
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
        // Solo los administradores pueden filtrar por sala
        if (!Auth::user()->isAdmin()) {
            abort(403, 'No tienes permiso para filtrar reservas por sala.');
        }
        
        // Validar que room_id exista y no esté vacío
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);
        $reservations = $room->reservations()->with('user')->latest()->get();
        $rooms = Room::all();

        return view('reservations.index', compact('reservations', 'rooms', 'room'));
    }
}