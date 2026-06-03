@extends('layouts.app')

@section('title', 'Absences')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-x-circle"></i> Liste des Absences</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('absences.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvelle Absence
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-danger">
                <tr>
                    <th>Agent</th>
                    <th>Jours</th>
                    <th>Date début</th>
                    <th>Motif</th>
                    <th>Déductible</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absences as $absence)
                <tr>
                    <td>{{ $absence->agent->nom }} {{ $absence->agent->prenom }}</td>
                    <td>{{ $absence->nombre_jours }}</td>
                    <td>{{ $absence->date_debut->format('d/m/Y') }}</td>
                    <td>{{ $absence->motif }}</td>
                    <td>
                        <span class="badge {{ $absence->deductible ? 'bg-danger' : 'bg-success' }}">
                            {{ $absence->deductible ? 'Oui' : 'Non' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('absences.show', $absence) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('absences.edit', $absence) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer cette absence ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune absence enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $absences->links() }}
    </div>
</div>
@endsection
