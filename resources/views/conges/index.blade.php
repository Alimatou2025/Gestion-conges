@extends('layouts.app')

@section('title', 'Congés')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar"></i> Liste des Congés</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('conges.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau Congé
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Agent</th>
                    <th>Jours pris</th>
                    <th>Date cessation</th>
                    <th>Date reprise</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conges as $conge)
                <tr>
                    <td>{{ $conge->agent->nom }} {{ $conge->agent->prenom }}</td>
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
                    <td>
                        <a href="{{ route('conges.show', $conge) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('conges.edit', $conge) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('conges.destroy', $conge) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer ce congé ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun congé enregistré</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $conges->links() }}
    </div>
</div>
@endsection
