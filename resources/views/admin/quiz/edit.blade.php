@extends('layouts.app')

@section('titre', 'Modifier le quiz')

@section('contenu')
    <h1 class="h3 mb-1">Modifier le quiz</h1>
    <p class="text-muted">{{ $quiz->chapitre->matiere->nom }} › {{ $quiz->chapitre->titre }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.quiz.update', $quiz) }}">
            @csrf
            @method('PUT')
            @include('admin.quiz._form', ['retour' => route('admin.quiz.show', $quiz)])
        </form>
    </div></div>
@endsection
