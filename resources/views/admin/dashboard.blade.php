@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Panel de Administración</h2>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Salas</h5>
                    <p class="card-text display-4">{{ $roomsCount }}</p>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('rooms.index') }}" class="text-white text-decoration-none">
                        Ver detalles
                        <span class="ms-1"><i class="bi bi-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Reservas</h5>
                    <p class="card-text display-4">{{ $reservationsCount }}</p>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Ver detalles
                        <span class="ms-1"><i class="bi bi-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <h5 class="card-title">Reservas Pendientes</h5>
                    <p class="card-text display-4">{{ $pendingReservationsCount }}</p>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('reservations.index') }}" class="text-dark text-decoration-none">
                        Ver detalles
                        <span class="ms-1"><i class="bi bi-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Acciones Rápidas
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary">Crear Nueva Sala</a>
                        <a href="{{ route('export.reservations') }}" class="btn btn-success">Exportar Reservas a Excel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Reservas Recientes
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($recentReservations as $reservation)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $reservation->user->name }}</strong> - {{ $reservation->room->name }}
                                    <br>
                                    <small>{{ $reservation->start_time->format('d/m/Y H:i') }}</small>
                                </div>
                                <span class="badge {{ $reservation->status == 'pending' ? 'bg-warning' : ($reservation->status == 'accepted' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item">No hay reservas recientes.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-primary">Ver todas las reservas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection