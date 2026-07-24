@extends('layouts.app')

@section('title', 'Demande de Congé')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar-plus"></i> Demande de Congé</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('employee.conges.demande') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre de jours à prendre</label>
                <input type="number" name="jours_a_prendre" class="form-control @error('jours_a_prendre') is-invalid @enderror"
                    value="{{ old('jours_a_prendre') }}" min="1">
                @error('jours_a_prendre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Date de cessation de service</label>
                <input type="date" name="date_cessation" class="form-control @error('date_cessation') is-invalid @enderror"
                    value="{{ old('date_cessation') }}">
                @error('date_cessation') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-send"></i> Soumettre la demande
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
