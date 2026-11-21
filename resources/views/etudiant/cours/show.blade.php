@extends('layouts.app')

@section('titre', $cours->titre)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item"><a href="{{ route('etudiant.matieres.show', $cours->chapitre->matiere) }}">{{ $cours->chapitre->matiere->nom }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('etudiant.chapitres.show', $cours->chapitre) }}">{{ $cours->chapitre->titre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $cours->titre }}</li>
        </ol>
    </nav>

    <article class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">{{ $cours->titre }}</h1>
            <div class="contenu-cours">{!! nl2br(e($cours->contenu)) !!}</div>
        </div>
    </article>

    <a href="{{ route('etudiant.chapitres.show', $cours->chapitre) }}" class="btn btn-outline-secondary mt-3">
        <i class="bi bi-arrow-left me-1"></i>Retour au chapitre
    </a>
@endsection
