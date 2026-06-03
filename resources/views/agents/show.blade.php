@extends('layouts.app')

@section('title', 'Détail Agent')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-person"></i> {{ $agent->nom }} {{ $agent->prenom }}</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('agents.edit', $agent) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('agents.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- Infos agent -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person-badge"></i> Informations personnelles
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Matricule</th>
                        <td>{{ $agent->matricule_solde }}</td>
                    </tr>
                    <tr>
                        <th>Nom & Prénom</th>
                        <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                    </tr>
                    <tr>
                        <th>Affectation</th>
                        <td>{{ $agent->lieu_affectation }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>
                            <span class="badge {{ $agent->type_agent == 'titulaire' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ ucfirst($agent->type_agent) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Nombre d'enfants</th>
                        <td>{{ $agent->nombre_enfants }}</td>
                    </tr>
                    <tr>
                        <th>Date de prise de service</th>
                        <td>{{ $agent->date_prise_service->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="bi bi-calendar-check"></i> Situation des congés
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Jours de congés dus</th>
                        <td><span class="badge bg-success fs-6">{{ $agent->jours_conges_dus }}</span></td>
                    </tr>
                    <tr>
                        <th>Jours reportés</th>
                        <td><span class="badge bg-info fs-6">{{ $agent->jours_reportes }}</span></td>
                    </tr>
                    <tr>
                        <th>Jours enfants</th>
                        <td><span class="badge bg-warning fs-6">{{ $agent->nombre_enfants }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Historique congés -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-calendar"></i> Historique des congés
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Jours pris</th>
                    <th>Date cessation</th>
                    <th>Date reprise</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agent->conges as $conge)
                <tr>
                    <td>{{ $conge->jours_a_prendre }}</td>
                    <td>{{ $conge->date_cessation->format('d/m/Y') }}</td>
                    <td>{{ $conge->date_reprise ? $conge->date_reprise->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge
                            {{ $conge->statut == 'approuve' ? 'bg-success' :
                               ($conge->statut == 'refuse' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($conge->statut) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun congé enregistré</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Historique absences -->
<div class="card">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-x-circle"></i> Historique des absences
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Jours</th>
                    <th>Date début</th>
                    <th>Motif</th>
                    <th>Déductible</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agent->absences as $absence)
                <tr>
                    <td>{{ $absence->nombre_jours }}</td>
                    <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
                    <td>{{ $absence->motif }}</td>
                    <td>
                        <span class="badge {{ $absence->deductible ? 'bg-danger' : 'bg-success' }}">
                            {{ $absence->deductible ? 'Oui' : 'Non' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune absence enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
