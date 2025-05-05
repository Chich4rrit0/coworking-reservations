@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Bienvenido, {{ Auth::user()->name }}!</h2>
                    
                    <div class="mt-4">
                        <h4>Acciones rápidas</h4>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('rooms.index') }}" class="btn btn-primary">
                                        <i class="bi bi-building"></i> Ver salas disponibles
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('reservations.create') }}" class="btn btn-success">
                                        <i class="bi bi-calendar-plus"></i> Hacer una reserva
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('reservations.index') }}" class="btn btn-info">
                                        <i class="bi bi-calendar-check"></i> Mis reservas
                                        @if(Auth::user()->isAdmin() && isset($pendingReservationsCount) && $pendingReservationsCount > 0)
                                            <span class="badge bg-danger">{{ $pendingReservationsCount }}</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            @if(Auth::user()->isAdmin())
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">
                                        <i class="bi bi-speedometer2"></i> Panel de administración
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection