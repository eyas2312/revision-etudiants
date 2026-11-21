@extends('layouts.app')

@section('titre', 'Nouvelle question')

@section('contenu')
    <h1 class="h3 mb-1">Nouvelle question</h1>
    <p class="text-muted">Quiz : {{ $quiz->titre }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.quiz.questions.store', $quiz) }}">
            @csrf
            @include('admin.questions._form')
        </form>
    </div></div>
@endsection
