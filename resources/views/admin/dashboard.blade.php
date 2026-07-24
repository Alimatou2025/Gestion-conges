@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Tableau de bord Administration</h2>
        <hr>
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Total Agents</h5>
                <h2>{{ $totalAgents }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar-check"></i> Congés en attente</h5>
                <h2>{{ $congesEnAttente->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-x-circle"></i> Absences en attente</h5>
                <h2>{{ $absencesEnAttente->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Demandes de congés en attente -->
<div class="card mb-4">
    <div class="card-header bg-warning text-white">
        <i class="bi bi-hourglass"></i> Demandes de congés en attente de validation
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Matricule</th>
                    <th>Jours demandés</th>
                    <th>Date cessation</th>
                    <th>Date reprise</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($congesEnAttente as $conge)
                <tr>
                    <td>{{ $conge->agent->nom }} {{ $conge->agent->prenom }}</td>
                    <td>{{ $conge->agent->matricule_solde }}</td>
                    <td><strong>{{ $conge->jours_a_prendre }}</strong></td>
                    <td>{{ $conge->date_cessation->format('d/m/Y') }}</td>
                    <td>{{ $conge->date_reprise ? $conge->date_reprise->format('d/m/Y') : '-' }}</td>
                    <td>
                        <form action="{{ route('admin.conges.valider', $conge->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i> Valider
                            </button>
                        </form>
                        <form action="{{ route('admin.conges.refuser', $conge->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i> Refuser
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune demande de congé en attente</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Demandes d'absences en attente -->
<div class="card mb-4">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-hourglass"></i> Demandes d'absences en attente de validation
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Matricule</th>
                    <th>Jours</th>
                    <th>Date début</th>
                    <th>Motif</th>
                    <th>Déductible</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absencesEnAttente as $absence)
                <tr>
                    <td>{{ $absence->agent->nom }} {{ $absence->agent->prenom }}</td>
                    <td>{{ $absence->agent->matricule_solde }}</td>
                    <td><strong>{{ $absence->nombre_jours }}</strong></td>
                    <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($absence->motif) }}</td>
                    <td>
                        <span class="badge {{ $absence->deductible ? 'bg-danger' : 'bg-success' }}">
                            {{ $absence->deductible ? 'Oui' : 'Non' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.absences.valider', $absence->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i> Valider
                            </button>
                        </form>
                        <form action="{{ route('admin.absences.refuser', $absence->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i> Refuser
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Aucune demande d'absence en attente</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Liste des agents -->
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <span><i class="bi bi-people"></i> Tous les agents</span>
        <a href="{{ route('admin.agents.index') }}" class="btn btn-sm btn-light">Voir tout</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Affectation</th>
                    <th>Jours dus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allAgents->take(5) as $agent)
                <tr>
                    <td>{{ $agent->matricule_solde }}</td>
                    <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                    <td>{{ $agent->lieu_affectation }}</td>
                    <td><span class="badge bg-success">{{ $agent->jours_conges_dus }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
