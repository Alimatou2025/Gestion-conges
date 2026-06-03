@extends('layouts.app')

@section('title', 'Détail Jour Férié')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-calendar-event"></i> Détail Jour Férié</h2>
    </div>
    <div class="col-4 text-end">
        <a href="{{ route('jours-feries.edit', $jourFerie) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('jours-feries.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-warning text-white">
        <i class="bi bi-info-circle"></i> Informations
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Nom</th>
                <td>{{ $jourFerie->nom }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $jourFerie->date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Se répète chaque année</th>
                <td>
                    <span class="badge {{ $jourFerie->annuel ? 'bg-success' : 'bg-secondary' }}">
                        {{ $jourFerie->annuel ? 'Oui' : 'Non' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
