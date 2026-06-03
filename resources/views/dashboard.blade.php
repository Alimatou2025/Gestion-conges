@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Tableau de bord</h2>
        <hr>
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Total Agents</h5>
                <h2>{{ $totalAgents }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar-check"></i> Total Congés</h5>
                <h2>{{ $totalConges }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-x-circle"></i> Total Absences</h5>
                <h2>{{ $totalAbsences }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-hourglass"></i> Congés en attente</h5>
                <h2>{{ $congesEnAttente }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Derniers agents -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-people"></i> Derniers agents ajoutés
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Affectation</th>
                            <th>Jours dus</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dernierAgents as $agent)
                        <tr>
                            <td>{{ $agent->matricule_solde }}</td>
                            <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                            <td>{{ $agent->lieu_affectation }}</td>
                            <td>{{ $agent->jours_conges_dus }}</td>
                            <td>
                                <a href="{{ route('agents.show', $agent) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun agent enregistré</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
