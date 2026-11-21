@extends('layouts.app')

@section('titre', $chapitre->titre)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.matieres.show', $chapitre->matiere) }}">{{ $chapitre->matiere->nom }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $chapitre->titre }}</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-4 gap-2">
        <h1 class="h3 mb-0">{{ $chapitre->titre }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-outline-secondary">Modifier</a>
            <a href="{{ route('admin.chapitres.suppression', $chapitre) }}" class="btn btn-outline-danger">Supprimer</a>
        </div>
    </div>

    {{-- Cours --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Cours</h2>
        <a href="{{ route('admin.chapitres.cours.create', $chapitre) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau cours</a>
    </div>
    <div class="card border-0 shadow-sm mb-4">
        <ul class="list-group list-group-flush">
            @forelse ($chapitre->cours as $cours)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.cours.show', $cours) }}" class="text-decoration-none fw-semibold">{{ $cours->titre }}</a>
                    <span class="text-nowrap">
                        <a href="{{ route('admin.cours.show', $cours) }}" class="btn btn-sm btn-outline-primary">Aperçu</a>
                        <a href="{{ route('admin.cours.edit', $cours) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                    </span>
                </li>
            @empty
                <li class="list-group-item text-center text-muted py-4">Aucun cours dans ce chapitre.</li>
            @endforelse
        </ul>
    </div>

    {{-- Quiz --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Quiz</h2>
        <a href="{{ route('admin.chapitres.quiz.create', $chapitre) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau quiz</a>
    </div>
    <div class="card border-0 shadow-sm">
        <ul class="list-group list-group-flush">
            @forelse ($chapitre->quiz as $quiz)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <a href="{{ route('admin.quiz.show', $quiz) }}" class="text-decoration-none fw-semibold">{{ $quiz->titre }}</a>
                        <span class="badge text-bg-secondary ms-2">{{ $quiz->questions_count }} question(s)</span>
                        @if ($quiz->tentatives_count > 0)
                            <span class="badge text-bg-warning ms-1"><i class="bi bi-lock-fill"></i> Verrouillé</span>
                        @endif
                    </span>
                    <a href="{{ route('admin.quiz.show', $quiz) }}" class="btn btn-sm btn-outline-primary">Ouvrir</a>
                </li>
            @empty
                <li class="list-group-item text-center text-muted py-4">Aucun quiz dans ce chapitre.</li>
            @endforelse
        </ul>
    </div>
@endsection
