@extends('layouts.app')

@section('titre', 'Modifier le cours')

@section('contenu')
    <h1 class="h3 mb-1">Modifier le cours</h1>
    <p class="text-muted">{{ $cours->chapitre->matiere->nom }} › {{ $cours->chapitre->titre }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.cours.update', $cours) }}">
            @csrf
            @method('PUT')
            @include('admin.cours._form', ['retour' => route('admin.cours.show', $cours)])
        </form>
    </div></div>
@endsection
