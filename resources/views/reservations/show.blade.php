@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar-event"></i> {{ __('Detalles de la Reserva') }}</span>
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a la lista
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ID de Reserva:</div>
                        <div class="col-md-8">{{ $reservation->id }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Cliente:</div>
                        <div class="col-md-8">{{ $reservation->user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Sala:</div>
                        <div class="col-md-8">{{ $reservation->room->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Fecha:</div>
                        <div class="col-md-8">{{ $reservation->start_time->format('d/m/Y') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Hora:</div>
                        <div class="col-md-8">{{ $reservation->start_time->format('H:i') }} - {{ $reservation->end_time->format('H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Estado:</div>
                        <div class="col-md-8">
                            @if($reservation->status == 'pending')
                                <span class="badge bg-warning">Pendiente</span>
                            @elseif($reservation->status == 'accepted')
                                <span class="badge bg-success">Aceptada</span>
                            @elseif($reservation->status == 'rejected')
                                <span class="badge bg-danger">Rechazada</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Creada el:</div>
                        <div class="col-md-8">{{ $reservation->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if(Auth::user()->isAdmin())
                    <div class="mt-4">
                        <h5><i class="bi bi-gear"></i> Acciones de administrador:</h5>
                        <div class="d-flex gap-2">
                            <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Aceptar
                                </button>
                            </form>
                            
                            <form action="{{ route('reservations.update-status', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-x-circle"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection