@extends('layouts.app')

@section('titre', $chapitre->titre)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item"><a href="{{ route('etudiant.matieres.show', $chapitre->matiere) }}">{{ $chapitre->matiere->nom }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $chapitre->titre }}</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">{{ $chapitre->titre }}</h1>

    <h2 class="h5">Cours</h2>
    <div class="list-group shadow-sm mb-4">
        @forelse ($cours as $c)
            <a href="{{ route('etudiant.cours.show', $c) }}" class="list-group-item list-group-item-action">
                <i class="bi bi-file-text me-2 text-primary"></i>{{ $c->titre }}
            </a>
        @empty
            <div class="list-group-item text-center text-muted py-3">Aucun cours dans ce chapitre.</div>
        @endforelse
    </div>

    <h2 class="h5">Quiz du chapitre</h2>
    <div class="list-group shadow-sm">
        @forelse ($quiz as $q)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="bi bi-patch-question me-2 text-primary"></i>{{ $q->titre }}
                    <span class="badge text-bg-secondary ms-1">{{ $q->questions_count }} question(s)</span>
                </span>
                <a href="{{ route('etudiant.quiz.show', $q) }}" class="btn btn-sm btn-primary">Commencer</a>
            </div>
        @empty
            <div class="list-group-item text-center text-muted py-3">Aucun quiz disponible pour ce chapitre.</div>
        @endforelse
    </div>
@endsection
