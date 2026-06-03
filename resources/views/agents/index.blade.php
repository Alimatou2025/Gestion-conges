@extends('layouts.app')

@section('title', 'Agents')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-people"></i> Liste des Agents</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('agents.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvel Agent
        </a>
    </div>
</div>

<!-- Recherche -->
<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Rechercher par matricule ou nom...">
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Affectation</th>
                    <th>Type</th>
                    <th>Jours dus</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agents as $agent)
                <tr>
                    <td>{{ $agent->matricule_solde }}</td>
                    <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                    <td>{{ $agent->lieu_affectation }}</td>
                    <td>
                        <span class="badge {{ $agent->type_agent == 'titulaire' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($agent->type_agent) }}
                        </span>
                    </td>
                    <td>{{ $agent->jours_conges_dus }}</td>
                    <td>
                        <a href="{{ route('agents.show', $agent) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('agents.edit', $agent) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('agents.destroy', $agent) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer cet agent ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun agent enregistré</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $agents->links() }}
    </div>
</div>
@endsection
