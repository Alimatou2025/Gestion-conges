@extends('layouts.app')

@section('title', 'Historique - Gestion Congés')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-clock-history"></i> Mon Historique</h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="conges-tab" data-bs-toggle="tab" data-bs-target="#conges" type="button" role="tab">
                    <i class="bi bi-calendar-check"></i> Demandes de Congé
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="absences-tab" data-bs-toggle="tab" data-bs-target="#absences" type="button" role="tab">
                    <i class="bi bi-exclamation-circle"></i> Demandes d'Absence
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Onglet Congés -->
            <div class="tab-pane fade show active" id="conges" role="tabpanel">
                @if($conges->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Du</th>
                                    <th>Au</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Demandé le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conges as $cong)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cong->date_debut)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cong->date_fin)->format('d/m/Y') }}</td>
                                        <td>
                                            @switch($cong->type_cong)
                                                @case('annuel')
                                                    Congé annuel
                                                    @break
                                                @case('maladie')
                                                    Congé maladie
                                                    @break
                                                @case('maternite')
                                                    Congé maternité
                                                    @break
                                                @default
                                                    Autres
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($cong->statut === 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($cong->statut === 'approuve')
                                                <span class="badge bg-success">Approuvé</span>
                                            @else
                                                <span class="badge bg-danger">Refusé</span>
                                            @endif
                                        </td>
                                        <td>{{ $cong->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav>{{ $conges->links() }}</nav>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucune demande de congé pour le moment
                    </div>
                @endif
            </div>

            <!-- Onglet Absences -->
            <div class="tab-pane fade" id="absences" role="tabpanel">
                @if($absences->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    <th>Signalée le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absences as $absence)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($absence->motif, 50) }}</td>
                                        <td>
                                            @if($absence->statut === 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($absence->statut === 'approuve')
                                                <span class="badge bg-success">Approuvée</span>
                                            @else
                                                <span class="badge bg-danger">Refusée</span>
                                            @endif
                                        </td>
                                        <td>{{ $absence->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav>{{ $absences->links() }}</nav>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucune demande d'absence pour le moment
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
