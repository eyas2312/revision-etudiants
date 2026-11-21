@extends('layouts.app')

@section('titre', 'Connexion')

@section('contenu')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h3 mb-1">Connexion</h1>
                    <p class="text-muted">Pas encore de compte ? <a href="{{ route('inscription') }}">Inscrivez-vous</a>.</p>

                    <form method="POST" action="{{ route('login.store') }}" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
