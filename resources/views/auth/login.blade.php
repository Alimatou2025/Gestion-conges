@extends('layouts.app')

@section('title', 'Connexion - Gestion Congés')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="font-weight-light my-1">Connexion</h3>
                    <p class="mb-0 small">Accédez à votre espace</p>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="small mb-1 font-weight-bold text-muted" for="email">Adresse Email</label>
                            <input class="form-control py-2 @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="nom@exemple.com" value="{{ old('email') }}" required />
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="small mb-1 font-weight-bold text-muted" for="password">Mot de passe</label>
                            <input class="form-control py-2 @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="••••••••" required />
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light border-0">
                    <div class="small"><a href="{{ route('register') }}">Pas encore de compte ? Inscrivez-vous</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
