@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detalles de la Sala') }}</span>
                    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-secondary">Volver a la lista</a>
                </div>

                <div class="card-body">
                    <h2>{{ $room->name }}</h2>
                    
                    <div class="mb-4">
                        <h5>Descripción:</h5>
                        <p>{{ $room->description ?? 'Sin descripción' }}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn btn-success">
                            <i class="bi bi-calendar-plus"></i> Reservar esta sala
                        </a>
                    </div>

                    @if(Auth::user()->isAdmin())
                    <div class="mt-4">
                        <h5>Acciones de administrador:</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta sala?')">
                                    <i class="bi bi-trash"></i> Eliminar
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