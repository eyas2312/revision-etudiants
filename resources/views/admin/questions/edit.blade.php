@extends('layouts.app')

@section('titre', 'Modifier la question')

@section('contenu')
    <h1 class="h3 mb-1">Modifier la question</h1>
    <p class="text-muted">Quiz : {{ $quiz->titre }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.questions.update', $question) }}">
            @csrf
            @method('PUT')
            @include('admin.questions._form')
        </form>
    </div></div>
@endsection
