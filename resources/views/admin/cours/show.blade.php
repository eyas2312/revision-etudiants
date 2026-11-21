@extends('layouts.app')

@section('titre', $cours->titre)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.matieres.show', $cours->chapitre->matiere) }}">{{ $cours->chapitre->matiere->nom }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.chapitres.show', $cours->chapitre) }}">{{ $cours->chapitre->titre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $cours->titre }}</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3 gap-2">
        <h1 class="h3 mb-0">{{ $cours->titre }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cours.edit', $cours) }}" class="btn btn-outline-secondary">Modifier</a>
            <form method="POST" action="{{ route('admin.cours.destroy', $cours) }}"
                  onsubmit="return confirm('Supprimer définitivement ce cours ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Supprimer</button>
            </form>
        </div>
    </div>

    <div class="alert alert-info py-2 small"><i class="bi bi-eye me-1"></i>Aperçu : voici le cours tel que l'étudiant le verra.</div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <div class="contenu-cours">{!! nl2br(e($cours->contenu)) !!}</div>
    </div></div>
@endsection
