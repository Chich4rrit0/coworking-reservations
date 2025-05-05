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
                                    <a href="{{ route('rooms.index') }}" class="btn btn-primary">Ver salas disponibles</a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('reservations.create') }}" class="btn btn-success">Hacer una reserva</a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('reservations.index') }}" class="btn btn-info">Mis reservas</a>
                                </div>
                            </div>
                            @can('admin')
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Panel de administración</a>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection