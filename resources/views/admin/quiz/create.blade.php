@extends('layouts.app')

@section('titre', 'Nouveau quiz')

@section('contenu')
    <h1 class="h3 mb-1">Nouveau quiz</h1>
    <p class="text-muted">{{ $chapitre->matiere->nom }} › {{ $chapitre->titre }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.chapitres.quiz.store', $chapitre) }}">
            @csrf
            @include('admin.quiz._form', ['retour' => route('admin.chapitres.show', $chapitre)])
        </form>
    </div></div>
@endsection
