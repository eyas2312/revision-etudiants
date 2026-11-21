@extends('layouts.app')

@section('titre', 'Résultat')

@section('contenu')
    @php($quiz = $tentative->quiz)

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.resultats.index') }}">Mes résultats</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $quiz->titre }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 text-center">
            <h1 class="h4 mb-1">{{ $quiz->titre }}</h1>
            <p class="text-muted">{{ $quiz->chapitre->matiere->nom }} › {{ $quiz->chapitre->titre }} · {{ $tentative->created_at->format('d/m/Y H:i') }}</p>

            <div class="score-cercle {{ $tentative->estReussie() ? 'text-success' : 'text-danger' }} my-2">
                {{ $tentative->score }} %
            </div>
            <div class="mt-2">
                <span class="badge fs-6 {{ $tentative->estReussie() ? 'text-bg-success' : 'text-bg-danger' }}">{{ $tentative->statut }}</span>
            </div>
            <p class="mt-2 mb-3">{{ $tentative->nb_bonnes }} bonne(s) réponse(s) sur {{ $tentative->nb_questions }} question(s)
                <span class="text-muted">· seuil de réussite : {{ \App\Models\Tentative::SEUIL_REUSSITE }} %</span></p>

            <div class="d-flex flex-wrap justify-content-center gap-2">
                @unless ($quiz->trashed())
                    <a href="{{ route('etudiant.quiz.show', $quiz) }}" class="btn btn-primary"><i class="bi bi-arrow-repeat me-1"></i>Refaire le quiz</a>
                @endunless
                <a href="{{ route('etudiant.resultats.index') }}" class="btn btn-outline-secondary">Mes résultats</a>
            </div>
        </div>
    </div>

    <h2 class="h5 mb-3">Corrections</h2>

    @foreach ($tentative->reponsesTentative as $i => $detail)
        @php($question = $detail->question)
        @php($bonne = $question->reponses->firstWhere('est_correcte', true))

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="h6 mb-2">Question {{ $i + 1 }}</h3>
                    @if ($detail->est_correcte)
                        <span class="badge text-bg-success"><i class="bi bi-check-lg"></i> Correct</span>
                    @else
                        <span class="badge text-bg-danger"><i class="bi bi-x-lg"></i> Incorrect</span>
                    @endif
                </div>
                <p>{!! nl2br(e($question->enonce)) !!}</p>

                <ul class="list-group mb-2">
                    @foreach ($question->reponses as $reponse)
                        @php($choisie = $detail->reponse_id !== null && (int) $detail->reponse_id === (int) $reponse->id)
                        <li class="list-group-item d-flex justify-content-between align-items-center
                            {{ $reponse->est_correcte ? 'reponse-correcte' : ($choisie ? 'reponse-incorrecte' : '') }}">
                            <span>{{ $reponse->libelle }}</span>
                            <span class="small">
                                @if ($choisie)<span class="badge text-bg-dark">Votre réponse</span>@endif
                                @if ($reponse->est_correcte)<span class="badge text-bg-success">Bonne réponse</span>@endif
                            </span>
                        </li>
                    @endforeach
                </ul>

                @if ($detail->reponse_id === null)
                    <p class="text-danger small mb-1"><i class="bi bi-exclamation-circle me-1"></i>Vous n'avez pas répondu à cette question (comptée fausse).</p>
                @endif

                @if ($question->explication)
                    <div class="alert alert-info py-2 mb-0 small"><i class="bi bi-lightbulb-fill me-1"></i><strong>Explication :</strong> {{ $question->explication }}</div>
                @endif
            </div>
        </div>
    @endforeach
@endsection
