@extends('layouts.app')

@section('titre', 'Matières')

@section('contenu')
    <h1 class="h3 mb-4">Mes matières</h1>

    <div class="row g-4">
        @forelse ($matieres as $matiere)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('etudiant.matieres.show', $matiere) }}" class="card h-100 border-0 shadow-sm text-decoration-none carte-fonction">
                    <div class="card-body">
                        <h2 class="h5 text-primary"><i class="bi bi-journal-bookmark-fill me-2"></i>{{ $matiere->nom }}</h2>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($matiere->description, 110) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <span class="badge text-bg-secondary">{{ $matiere->chapitres_count }} chapitre(s)</span>
                        <span class="badge text-bg-secondary">{{ $matiere->quiz_count }} quiz</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Aucune matière n'est disponible pour le moment.</div></div>
        @endforelse
    </div>
@endsection
