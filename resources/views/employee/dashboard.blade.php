@extends('layouts.app')

@section('title', 'Mon Espace')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-person-circle"></i> Bienvenue, {{ Auth::user()->name }}</h2>
        <hr>
    </div>
</div>

@if(!$agent)
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i> Aucune fiche agent n'est encore liée à votre compte. Contactez l'administration.
</div>
@else

<!-- Compteurs -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar-check"></i> Mon solde de congés</h5>
                <h2>{{ $agent->jours_conges_dus }} jours</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> Mon matricule</h5>
                <h2>{{ $agent->matricule_solde }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> Mon affectation</h5>
                <h5 class="mt-2">{{ $agent->lieu_affectation }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Boutons d'action -->
<div class="row mb-4">
    <div class="col-md-6">
        <a href="{{ route('employee.conges.demande') }}" class="btn btn-success btn-lg w-100">
            <i class="bi bi-calendar-plus"></i> Faire une demande de congé
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('employee.absences.demande') }}" class="btn btn-danger btn-lg w-100">
            <i class="bi bi-x-circle"></i> Faire une demande d'absence
        </a>
    </div>
</div>

<!-- Historique des congés -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <i class="bi bi-calendar"></i> Mes demandes de congés
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Jours demandés</th>
                    <th>Date cessation</th>
                    <th>Date reprise</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conges as $conge)
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
                    <td colspan="4" class="text-center">Aucune demande de congé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Historique des absences -->
<div class="card">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-x-circle"></i> Mes demandes d'absences
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Jours</th>
                    <th>Date début</th>
                    <th>Motif</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absences as $absence)
                <tr>
                    <td>{{ $absence->nombre_jours }}</td>
                    <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($absence->motif) }}</td>
                    <td>
                        <span class="badge
                            {{ $absence->statut == 'approuve' ? 'bg-success' :
                               ($absence->statut == 'refuse' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($absence->statut) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune demande d'absence</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
