@extends('layouts.app')

@section('titre', $matiere->nom)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.matieres.index') }}">Matières</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $matiere->nom }}</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3 gap-2">
        <div>
            <h1 class="h3 mb-1">{{ $matiere->nom }}</h1>
            <p class="text-muted mb-0">{{ $matiere->description }}</p>
            <span class="badge text-bg-secondary">{{ $matiere->chapitres_count }} chapitre(s)</span>
            <span class="badge text-bg-secondary">{{ $matiere->quiz_count }} quiz</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-outline-secondary">Modifier</a>
            <a href="{{ route('admin.matieres.suppression', $matiere) }}" class="btn btn-outline-danger">Supprimer</a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Chapitres</h2>
        <a href="{{ route('admin.matieres.chapitres.create', $matiere) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau chapitre</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th style="width:5rem">Ordre</th><th>Titre</th><th class="text-center">Cours</th><th class="text-center">Quiz</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($chapitres as $chapitre)
                        <tr>
                            <td>{{ $chapitre->ordre }}</td>
                            <td class="fw-semibold"><a href="{{ route('admin.chapitres.show', $chapitre) }}" class="text-decoration-none">{{ $chapitre->titre }}</a></td>
                            <td class="text-center">{{ $chapitre->cours_count }}</td>
                            <td class="text-center">{{ $chapitre->quiz_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="btn btn-sm btn-outline-primary">Ouvrir</a>
                                <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <a href="{{ route('admin.chapitres.suppression', $chapitre) }}" class="btn btn-sm btn-outline-danger">Supprimer</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucun chapitre dans cette matière.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
