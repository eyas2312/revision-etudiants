@extends('layouts.app')

@section('titre', 'Inscription')

@section('contenu')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h3 mb-1">Créer un compte étudiant</h1>
                    <p class="text-muted">Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a>.</p>

                    <form method="POST" action="{{ route('inscription.store') }}" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" maxlength="100" required autofocus
                                       class="form-control @error('nom') is-invalid @enderror">
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" maxlength="100" required
                                       class="form-control @error('prenom') is-invalid @enderror">
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" id="password" name="password" required autocomplete="new-password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">8 caractères minimum.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                       class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">
                            <i class="bi bi-person-plus me-1"></i>S'inscrire
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
