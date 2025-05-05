@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h2>
                @if(Auth::user()->isAdmin())
                    Gestión de Reservaciones
                @else
                    Mis Reservaciones
                @endif
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Reserva
            </a>
            
            @if(Auth::user()->isAdmin())
            <a href="{{ route('export.reservations') }}" class="btn btn-success ms-2">
                <i class="bi bi-file-excel"></i> Exportar a Excel
            </a>
            @endif
        </div>
    </div>

    @if(Auth::user()->isAdmin())
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-funnel"></i> Filtrar por sala
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.filter') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <select name="room_id" class="form-select" required>
                                <option value="">Selecciona una sala</option>
                                @foreach($rooms ?? [] as $roomOption)
                                <option value="{{ $roomOption->id }}" {{ isset($room) && $room->id == $roomOption->id ? 'selected' : '' }}>
                                    {{ $roomOption->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if(isset($room))
                        <i class="bi bi-calendar-check"></i> Reservaciones para {{ $room->name }}
                    @else
                        <i class="bi bi-calendar-check"></i> Todas las reservaciones
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    @if(Auth::user()->isAdmin())
                                    <th>Cliente</th>
                                    @endif
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
                                    @if(Auth::user()->isAdmin())
                                    <td>{{ $reservation->user->name }}</td>
                                    @endif
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
                                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                        
                                        @if(Auth::user()->isAdmin())
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-gear"></i> Estado
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="bi bi-check-circle"></i> Aceptar
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-x-circle"></i> Rechazar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
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