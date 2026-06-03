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
                <small>agents enregistrés</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar-check"></i> Total Congés</h5>
                <h2>{{ $totalConges }}</h2>
                <small>congés enregistrés</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-x-circle"></i> Total Absences</h5>
                <h2>{{ $totalAbsences }}</h2>
                <small>absences enregistrées</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-hourglass"></i> Congés en attente</h5>
                <h2>{{ $congesEnAttente }}</h2>
                <small>en attente d'approbation</small>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-bar-chart"></i> Agents par affectation
            </div>
            <div class="card-body">
                <canvas id="agentsChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="bi bi-pie-chart"></i> Statut des congés
            </div>
            <div class="card-body">
                <canvas id="congesChart" height="200"></canvas>
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
                            <td>
                                <span class="badge bg-success">{{ $agent->jours_conges_dus }}</span>
                            </td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const agentsCtx = document.getElementById('agentsChart').getContext('2d');
    new Chart(agentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($agentsParAffectation->pluck('lieu_affectation')) !!},
            datasets: [{
                label: "Nombre d'agents",
                data: {!! json_encode($agentsParAffectation->pluck('total')) !!},
                backgroundColor: ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    const congesCtx = document.getElementById('congesChart').getContext('2d');
    new Chart(congesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Approuvés', 'En attente', 'Refusés'],
            datasets: [{
                data: [{{ $congesApprouves }}, {{ $congesEnAttente }}, {{ $congesRefuses }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            }]
        },
        options: { responsive: true }
    });
});
</script>
@endsection
