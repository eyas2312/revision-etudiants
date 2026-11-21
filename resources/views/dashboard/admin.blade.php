@extends('layouts.app')

@section('titre', 'Tableau de bord administrateur')

@section('contenu')
    <h1 class="h3 mb-1">Espace administrateur</h1>
    <p class="text-muted mb-4">Bienvenue {{ auth()->user()->prenom }} ! Gérez le contenu pédagogique de l'application.</p>

    <div class="row g-3 mb-4">
        @foreach ($stats as $libelle => $valeur)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <div class="display-6 fw-bold text-primary">{{ $valeur }}</div>
                        <div class="text-muted small">{{ $libelle }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <a href="{{ route('admin.matieres.index') }}" class="card border-0 shadow-sm text-decoration-none carte-fonction h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Matières, chapitres et cours</h2>
                    <p class="text-muted mb-0">Créez et organisez le contenu à réviser.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.quiz.index') }}" class="card border-0 shadow-sm text-decoration-none carte-fonction h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-patch-question-fill text-primary me-2"></i>Quiz et questions</h2>
                    <p class="text-muted mb-0">Composez les quiz d'évaluation des étudiants.</p>
                </div>
            </a>
        </div>
    </div>
@endsection
