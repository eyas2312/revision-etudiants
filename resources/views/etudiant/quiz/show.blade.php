@extends('layouts.app')

@section('titre', $quiz->titre)

@section('contenu')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.quiz.index') }}">Quiz</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $quiz->titre }}</li>
        </ol>
    </nav>

    <h1 class="h3 mb-1">{{ $quiz->titre }}</h1>
    <p class="text-muted mb-4">{{ $quiz->chapitre->matiere->nom }} › {{ $quiz->chapitre->titre }} · {{ $quiz->questions->count() }} question(s)</p>

    <form method="POST" action="{{ route('etudiant.quiz.soumettre', $quiz) }}" id="form-quiz">
        @csrf

        @foreach ($quiz->questions as $i => $question)
            <fieldset class="card border-0 shadow-sm mb-3" data-question>
                <div class="card-body">
                    <legend class="h6 mb-2">
                        Question {{ $i + 1 }} / {{ $quiz->questions->count() }}
                        <span class="badge text-bg-light border ms-1">{{ $question->type->libelle() }}</span>
                    </legend>
                    <p>{!! nl2br(e($question->enonce)) !!}</p>

                    @foreach ($question->reponses as $reponse)
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="choix[{{ $question->id }}]"
                                   id="reponse-{{ $reponse->id }}" value="{{ $reponse->id }}">
                            <label class="form-check-label" for="reponse-{{ $reponse->id }}">{{ $reponse->libelle }}</label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        @endforeach

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-flag-fill me-1"></i>Terminer le quiz</button>
            <a href="{{ route('etudiant.quiz.index') }}" class="btn btn-outline-secondary btn-lg">Abandonner</a>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/quiz.js') }}"></script>
@endpush
