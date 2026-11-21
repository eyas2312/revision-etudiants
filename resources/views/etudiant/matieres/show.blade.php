@extends('layouts.app')

@section('titre', $matiere->nom)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $matiere->nom }}</li>
        </ol>
    </nav>

    <h1 class="h3 mb-1">{{ $matiere->nom }}</h1>
    <p class="text-muted mb-4">{{ $matiere->description }}</p>

    <div class="list-group shadow-sm">
        @forelse ($chapitres as $chapitre)
            <a href="{{ route('etudiant.chapitres.show', $chapitre) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span><span class="text-muted me-2">{{ $chapitre->ordre }}.</span><strong>{{ $chapitre->titre }}</strong></span>
                <span>
                    <span class="badge text-bg-secondary">{{ $chapitre->cours_count }} cours</span>
                    <span class="badge text-bg-secondary">{{ $chapitre->quiz_count }} quiz</span>
                </span>
            </a>
        @empty
            <div class="list-group-item text-center text-muted py-4">Cette matière ne contient pas encore de chapitre.</div>
        @endforelse
    </div>
@endsection
