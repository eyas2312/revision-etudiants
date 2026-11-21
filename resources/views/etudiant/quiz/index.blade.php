@extends('layouts.app')

@section('titre', 'Quiz')

@section('contenu')
    <h1 class="h3 mb-4">Quiz disponibles</h1>

    @forelse ($groupes as $titreGroupe => $quizDuGroupe)
        <h2 class="h6 text-muted text-uppercase mt-4">{{ $titreGroupe }}</h2>
        <div class="list-group shadow-sm">
            @foreach ($quizDuGroupe as $q)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-patch-question me-2 text-primary"></i><strong>{{ $q->titre }}</strong>
                        <span class="badge text-bg-secondary ms-1">{{ $q->questions_count }} question(s)</span>
                    </span>
                    <a href="{{ route('etudiant.quiz.show', $q) }}" class="btn btn-sm btn-primary">Commencer</a>
                </div>
            @endforeach
        </div>
    @empty
        <div class="alert alert-info">Aucun quiz n'est disponible pour le moment.</div>
    @endforelse
@endsection
