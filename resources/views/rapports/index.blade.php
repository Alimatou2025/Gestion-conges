@extends('layouts.app')

@section('title', 'Rapports')

@section('content')
<div class="row mb-4">
    <div class="col-8">
        <h2><i class="bi bi-file-earmark-text"></i> Rapports</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-building"></i> Par Direction
            </div>
            <div class="card-body">
                <p>Générer un tableau des congés dus par direction.</p>
                <a href="{{ route('rapports.generer', ['type' => 'direction']) }}" class="btn btn-primary">
                    <i class="bi bi-download"></i> Générer
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <i class="bi bi-mortarboard"></i> Par UFR
            </div>
            <div class="card-body">
                <p>Générer un tableau des congés dus par UFR.</p>
                <a href="{{ route('rapports.generer', ['type' => 'ufr']) }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Générer
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-white">
                <i class="bi bi-bank"></i> Rectorat / Vice-Recteur
            </div>
            <div class="card-body">
                <p>Générer un tableau des congés dus pour le Rectorat et Vice-Recteur.</p>
                <a href="{{ route('rapports.generer', ['type' => 'rectorat']) }}" class="btn btn-warning">
                    <i class="bi bi-download"></i> Générer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
