@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h2>Salas de Coworking</h2>
        </div>
        <div class="col-md-6 text-end">
            @if(Auth::user()->isAdmin())
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Sala
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        @forelse ($rooms as $room)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="card-text">{{ $room->description ?? 'Sin descripción' }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Ver detalles
                            </a>
                            <div>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta sala?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No hay salas disponibles en este momento.
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('rooms.create') }}" class="alert-link">Crear una nueva sala</a>.
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection