@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Nueva Reserva') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="room_id" class="form-label">{{ __('Sala') }}</label>
                            <select id="room_id" class="form-select @error('room_id') is-invalid @enderror" name="room_id" required>
                                <option value="">Selecciona una sala</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('room_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">{{ __('Fecha') }}</label>
                            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}">

                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">{{ __('Hora') }}</label>
                            <input id="time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required>

                            @error('time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Las reservas son de 1 hora de duración.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Crear Reserva') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection