@extends('layouts.app')

@section('title', 'Nouveau Congé')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar-plus"></i> Nouveau Congé</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('conges.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('conges.store') }}" method="POST">
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
                    <label class="form-label">Nombre de jours à prendre</label>
                    <input type="number" name="jours_a_prendre" class="form-control @error('jours_a_prendre') is-invalid @enderror"
                        value="{{ old('jours_a_prendre') }}" min="1">
                    @error('jours_a_prendre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de cessation de service</label>
                    <input type="date" name="date_cessation" class="form-control @error('date_cessation') is-invalid @enderror"
                        value="{{ old('date_cessation') }}">
                    @error('date_cessation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select @error('statut') is-invalid @enderror">
                        <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="approuve" {{ old('statut') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                        <option value="refuse" {{ old('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                    </select>
                    @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire') }}</textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Congé exceptionnel ?</label>
                    <div class="form-check">
                        <input type="checkbox" name="exceptionnel" class="form-check-input" value="1"
                            {{ old('exceptionnel') ? 'checked' : '' }}>
                        <label class="form-check-label">Oui</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Déductible ?</label>
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
