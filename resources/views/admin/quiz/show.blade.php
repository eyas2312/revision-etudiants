@extends('layouts.app')

@section('titre', $quiz->titre)

@section('contenu')
    @php($verrouille = $quiz->tentatives_count > 0)

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.quiz.index') }}">Quiz</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.chapitres.show', $quiz->chapitre) }}">{{ $quiz->chapitre->matiere->nom }} › {{ $quiz->chapitre->titre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $quiz->titre }}</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3 gap-2">
        <div>
            <h1 class="h3 mb-2">{{ $quiz->titre }}</h1>
            <span class="badge text-bg-secondary">{{ $quiz->questions->count() }} question(s)</span>
            <span class="badge text-bg-secondary">{{ $quiz->tentatives_count }} tentative(s)</span>
            @if ($verrouille)
                <span class="badge text-bg-warning"><i class="bi bi-lock-fill"></i> Verrouillé</span>
            @elseif ($quiz->questions->isEmpty())
                <span class="badge text-bg-secondary">En préparation : ajoutez au moins une question</span>
            @else
                <span class="badge text-bg-success">Disponible pour les étudiants</span>
            @endif
        </div>
        <div class="d-flex gap-2">
            @unless ($verrouille)
                <a href="{{ route('admin.quiz.edit', $quiz) }}" class="btn btn-outline-secondary">Modifier</a>
            @endunless
            <a href="{{ route('admin.quiz.suppression', $quiz) }}" class="btn btn-outline-danger">
                {{ $verrouille ? 'Archiver' : 'Supprimer' }}
            </a>
        </div>
    </div>

    @if ($verrouille)
        <div class="alert alert-warning">
            <i class="bi bi-lock-fill me-1"></i>Des étudiants ont déjà passé ce quiz : il est verrouillé.
            Ses questions et réponses ne peuvent plus être modifiées, afin que les corrections restent exactes.
            Vous pouvez seulement le consulter ou l'archiver.
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Questions</h2>
        @unless ($verrouille)
            <a href="{{ route('admin.quiz.questions.create', $quiz) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle question</a>
        @endunless
    </div>

    @forelse ($quiz->questions as $i => $question)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div>
                        <h3 class="h6 mb-1">Question {{ $i + 1 }}
                            <span class="badge text-bg-light border ms-1">{{ $question->type->libelle() }}</span>
                        </h3>
                        <p class="mb-2">{!! nl2br(e($question->enonce)) !!}</p>
                    </div>
                    @unless ($verrouille)
                        <div class="text-nowrap">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette question ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    @endunless
                </div>
                <ul class="list-unstyled mb-0">
                    @foreach ($question->reponses as $reponse)
                        <li class="{{ $reponse->est_correcte ? 'text-success fw-semibold' : 'text-muted' }}">
                            <i class="bi {{ $reponse->est_correcte ? 'bi-check-circle-fill' : 'bi-circle' }} me-1"></i>{{ $reponse->libelle }}
                        </li>
                    @endforeach
                </ul>
                @if ($question->explication)
                    <p class="small text-muted mt-2 mb-0"><i class="bi bi-lightbulb me-1"></i>{{ $question->explication }}</p>
                @endif
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm"><div class="card-body text-center text-muted py-4">Ce quiz ne contient aucune question.</div></div>
    @endforelse
@endsection
