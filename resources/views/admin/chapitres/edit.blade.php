@extends('layouts.app')

@section('titre', 'Modifier le chapitre')

@section('contenu')
    <h1 class="h3 mb-1">Modifier le chapitre</h1>
    <p class="text-muted">Matière : {{ $chapitre->matiere->nom }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.chapitres.update', $chapitre) }}">
            @csrf
            @method('PUT')
            @include('admin.chapitres._form', ['retour' => route('admin.chapitres.show', $chapitre)])
        </form>
    </div></div>
@endsection
