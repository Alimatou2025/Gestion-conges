@extends('layouts.app')

@section('title', 'Nouvelle Absence')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-x-circle"></i> Nouvelle Absence</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('absences.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('absences.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Agent</label>
                    <select name="agent_id" class="form-select @error('agent_id') is-invalid @enderror">
                        <option value="">-- Sélectionner un agent --</option>
                        @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                            {{ $agent->matricule_solde }} - {{ $agent->nom }} {{ $agent->prenom }}
                        </option>
                        @endforeach
                    </select>
                    @error('agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre de jours</label>
                    <input type="number" name="nombre_jours" class="form-control @error('nombre_jours') is-invalid @enderror"
                        value="{{ old('nombre_jours') }}" min="1">
                    @error('nombre_jours') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de début</label>
                    <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror"
                        value="{{ old('date_debut') }}">
                    @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de fin</label>
                    <input type="date" name="date_fin" class="form-control"
                        value="{{ old('date_fin') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Motif</label>
                    <select name="motif" class="form-select @error('motif') is-invalid @enderror">
                        <option value="">-- Sélectionner un motif --</option>
                        <option value="maladie" {{ old('motif') == 'maladie' ? 'selected' : '' }}>Maladie</option>
                        <option value="mariage" {{ old('motif') == 'mariage' ? 'selected' : '' }}>Mariage</option>
                        <option value="bapteme" {{ old('motif') == 'bapteme' ? 'selected' : '' }}>Baptême</option>
                        <option value="deces" {{ old('motif') == 'deces' ? 'selected' : '' }}>Décès</option>
                        <option value="autre" {{ old('motif') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Déductible des congés ?</label>
                    <div class="form-check">
                        <input type="checkbox" name="deductible" class="form-check-input" value="1"
                            {{ old('deductible', true) ? 'checked' : '' }}>
                        <label class="form-check-label">Oui</label>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
