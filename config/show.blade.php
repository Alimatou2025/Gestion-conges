@extends('layouts.app')

@section('title', 'Détail Absence')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-x-circle"></i> Détail de l'Absence</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('absences.edit', $absence) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('absences.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-info-circle"></i> Informations de l'absence
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Agent</th>
                <td>{{ $absence->agent->nom }} {{ $absence->agent->prenom }}</td>
            </tr>
            <tr>
                <th>Matricule</th>
                <td>{{ $absence->agent->matricule_solde }}</td>
            </tr>
            <tr>
                <th>Nombre de jours</th>
                <td>{{ $absence->nombre_jours }}</td>
            </tr>
            <tr>
                <th>Date de début</th>
                <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Date de fin</th>
                <td>{{ $absence->date_fin ? $absence->date_fin->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Motif</th>
                <td>{{ ucfirst($absence->motif) }}</td>
            </tr>
            <tr>
                <th>Déductible</th>
                <td>
                    <span class="badge {{ $absence->deductible ? 'bg-danger' : 'bg-success' }}">
                        {{ $absence->deductible ? 'Oui' : 'Non' }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Commentaire</th>
                <td>{{ $absence->commentaire ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
