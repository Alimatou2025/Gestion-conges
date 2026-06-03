@extends('layouts.app')

@section('title', 'Jours Fériés')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar-event"></i> Jours Fériés</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('jours-feries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau Jour Férié
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-warning">
                <tr>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Annuel</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($joursFeries as $jourFerie)
                <tr>
                    <td>{{ $jourFerie->nom }}</td>
                    <td>{{ $jourFerie->date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $jourFerie->annuel ? 'bg-success' : 'bg-secondary' }}">
                            {{ $jourFerie->annuel ? 'Oui' : 'Non' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('jours-feries.edit', $jourFerie) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('jours-feries.destroy', $jourFerie) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer ce jour férié ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun jour férié enregistré</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $joursFeries->links() }}
    </div>
</div>
@endsection
