@extends('layouts.app')

@section('title', 'Détail Congé')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar"></i> Détail du Congé</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('conges.edit', $conge) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('conges.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-info-circle"></i> Informations du congé
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Agent</th>
                <td>{{ $conge->agent->nom }} {{ $conge->agent->prenom }}</td>
            </tr>
            <tr>
                <th>Matricule</th>
                <td>{{ $conge->agent->matricule_solde }}</td>
            </tr>
            <tr>
                <th>Jours à prendre</th>
                <td>{{ $conge->jours_a_prendre }}</td>
            </tr>
            <tr>
                <th>Date de cessation</th>
                <td>{{ $conge->date_cessation->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Date de reprise</th>
                <td>{{ $conge->date_reprise ? $conge->date_reprise->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>
                    <span class="badge
                        {{ $conge->statut == 'approuve' ? 'bg-success' :
                           ($conge->statut == 'refuse' ? 'bg-danger' : 'bg-warning') }}">
                        {{ ucfirst($conge->statut) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Exceptionnel</th>
                <td>{{ $conge->exceptionnel ? 'Oui' : 'Non' }}</td>
            </tr>
            <tr>
                <th>Déductible</th>
                <td>{{ $conge->deductible ? 'Oui' : 'Non' }}</td>
            </tr>
            <tr>
                <th>Commentaire</th>
                <td>{{ $conge->commentaire ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
