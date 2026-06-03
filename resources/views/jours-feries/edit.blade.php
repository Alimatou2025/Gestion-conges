@extends('layouts.app')

@section('title', 'Modifier Jour Férié')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-pencil"></i> Modifier Jour Férié</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('jours-feries.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('jours-feries.update', $jourFerie) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom du jour férié</label>
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                        value="{{ old('nom', $jourFerie->nom) }}">
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date', $jourFerie->date->format('Y-m-d')) }}">
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Se répète chaque année ?</label>
                    <div class="form-check">
                        <input type="checkbox" name="annuel" class="form-check-input" value="1"
                            {{ old('annuel', $jourFerie->annuel) ? 'checked' : '' }}>
                        <label class="form-check-label">Oui</label>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Modifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
