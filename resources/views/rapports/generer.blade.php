@extends('layouts.app')

@section('title', 'Rapport généré')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-file-earmark-text"></i>
            Rapport -
            @if($type == 'direction') Directions
            @elseif($type == 'ufr') UFR
            @else Rectorat / Vice-Recteur
            @endif
        </h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('rapports.export-pdf', ['type' => $type]) }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Exporter PDF
        </a>
        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Affectation</th>
                    <th>Jours de congés dus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agents as $agent)
                <tr>
                    <td>{{ $agent->matricule_solde }}</td>
                    <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                    <td>{{ $agent->lieu_affectation }}</td>
                    <td>
                        <span class="badge bg-success fs-6">
                            {{ $agent->jours_conges_dus }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun agent trouvé pour cette catégorie</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
