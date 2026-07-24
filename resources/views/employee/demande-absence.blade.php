@extends('layouts.app')

@section('title', 'Demande d\'Absence')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-exclamation-circle"></i> Demande d'Absence</h2>
        <hr>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employee.demande-absence.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Date de l'absence</label>
                        <input type="date" name="date_absence" class="form-control @error('date_absence') is-invalid @enderror"
                            value="{{ old('date_absence') }}" required>
                        @error('date_absence')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Motif</label>
                        <textarea name="motif" class="form-control @error('motif') is-invalid @enderror" rows="4" required>{{ old('motif') }}</textarea>
                        @error('motif')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Document justificatif (optionnel)</label>
                        <input type="file" name="document" class="form-control @error('document') is-invalid @enderror"
                            accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">PDF, JPG, PNG - Max 2MB</small>
                        @error('document')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Soumettre la demande
                        </button>
                        <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
