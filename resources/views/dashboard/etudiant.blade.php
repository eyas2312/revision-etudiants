@extends('layouts.app')

@section('titre', 'Tableau de bord étudiant')

@section('contenu')
    <h1 class="h3 mb-1">Espace étudiant</h1>
    <p class="text-muted mb-4">Bienvenue {{ auth()->user()->prenom }} ! Prêt à réviser ?</p>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('etudiant.matieres.index') }}" class="card border-0 shadow-sm text-decoration-none carte-fonction h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Mes matières</h2>
                    <p class="text-muted mb-0">Consultez les cours par chapitre.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('etudiant.quiz.index') }}" class="card border-0 shadow-sm text-decoration-none carte-fonction h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-patch-question-fill text-primary me-2"></i>Quiz</h2>
                    <p class="text-muted mb-0">Testez vos connaissances.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('etudiant.resultats.index') }}" class="card border-0 shadow-sm text-decoration-none carte-fonction h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i>Mes résultats</h2>
                    <p class="text-muted mb-0">Retrouvez vos tentatives et corrections.</p>
                </div>
            </a>
        </div>
    </div>

    @if ($dernieresTentatives->isNotEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Mes dernières tentatives</div>
            <ul class="list-group list-group-flush">
                @foreach ($dernieresTentatives as $tentative)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <a href="{{ route('etudiant.resultats.show', $tentative) }}">{{ $tentative->quiz->titre }}</a>
                            <small class="text-muted ms-2">{{ $tentative->created_at->format('d/m/Y H:i') }}</small>
                        </span>
                        <span>
                            <strong>{{ $tentative->score }} %</strong>
                            <span class="badge {{ $tentative->estReussie() ? 'text-bg-success' : 'text-bg-danger' }} ms-1">{{ $tentative->statut }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
