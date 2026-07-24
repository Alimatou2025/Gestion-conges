@extends('layouts.app')

@section('title', 'Inscription - Gestion Congés')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="font-weight-light my-1">Créer un compte</h3>
                    <p class="mb-0 small">Enregistrez-vous en tant qu'agent</p>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="name">Nom complet</label>
                            <input class="form-control py-2 @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Ex: Alimatou Dieme" value="{{ old('name') }}" required />
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="email">Adresse Email</label>
                            <input class="form-control py-2 @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="nom@exemple.com" value="{{ old('email') }}" required />
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="matricule_solde">Matricule de solde</label>
                            <input class="form-control py-2 @error('matricule_solde') is-invalid @enderror" id="matricule_solde" name="matricule_solde" type="text" placeholder="Ex: 6543T" value="{{ old('matricule_solde') }}" required />
                            @error('matricule_solde')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="lieu_affectation">Lieu d'affectation</label>
                            <input class="form-control py-2 @error('lieu_affectation') is-invalid @enderror" id="lieu_affectation" name="lieu_affectation" type="text" placeholder="Ex: Rectorat" value="{{ old('lieu_affectation') }}" required />
                            @error('lieu_affectation')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="date_prise_service">Date de prise de service</label>
                            <input class="form-control py-2 @error('date_prise_service') is-invalid @enderror" id="date_prise_service" name="date_prise_service" type="date" value="{{ old('date_prise_service') }}" required />
                            @error('date_prise_service')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="password">Mot de passe</label>
                            <input class="form-control py-2 @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Minimum 6 caractères" required />
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="small mb-1 font-weight-bold text-muted" for="password_confirmation">Confirmer le mot de passe</label>
                            <input class="form-control py-2" id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" required />
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-block">Créer le compte</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light border-0">
                    <div class="small"><a href="{{ route('login') }}">Déjà un compte ? Connectez-vous</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
