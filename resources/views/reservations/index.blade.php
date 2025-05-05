@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h2>Mis Reservaciones</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Reserva
            </a>
            
            @can('admin')
            <a href="{{ route('export.reservations') }}" class="btn btn-success ms-2">
                <i class="bi bi-file-excel"></i> Exportar a Excel
            </a>
            @endcan
        </div>
    </div>

    @can('admin')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Filtrar por sala
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.filter') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <select name="room_id" class="form-select">
                                <option value="">Todas las salas</option>
                                @foreach($rooms ?? [] as $roomOption)
                                <option value="{{ $roomOption->id }}" {{ isset($room) && $room->id == $roomOption->id ? 'selected' : '' }}>
                                    {{ $roomOption->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ isset($room) ? 'Reservaciones para ' . $room->name : 'Todas las reservaciones' }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    @can('admin')
                                    <th>Cliente</th>
                                    @endcan
                                    <th>Sala</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    @can('admin')
                                    <td>{{ $reservation->user->name }}</td>
                                    @endcan
                                    <td>{{ $reservation->room->name }}</td>
                                    <td>{{ $reservation->start_time->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->start_time->format('H:i') }} - {{ $reservation->end_time->format('H:i') }}</td>
                                    <td>
                                        @if($reservation->status == 'pending')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($reservation->status == 'accepted')
                                            <span class="badge bg-success">Aceptada</span>
                                        @elseif($reservation->status == 'rejected')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info">Ver</a>
                                        
                                        @can('updateStatus', $reservation)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Cambiar estado
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="dropdown-item">Aceptar</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="dropdown-item">Rechazar</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}" class="text-center">No hay reservaciones disponibles.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection