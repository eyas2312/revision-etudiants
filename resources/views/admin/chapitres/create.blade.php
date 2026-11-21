@extends('layouts.app')

@section('titre', 'Nouveau chapitre')

@section('contenu')
    <h1 class="h3 mb-1">Nouveau chapitre</h1>
    <p class="text-muted">Matière : {{ $matiere->nom }}</p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.matieres.chapitres.store', $matiere) }}">
            @csrf
            @include('admin.chapitres._form', ['retour' => route('admin.matieres.show', $matiere)])
        </form>
    </div></div>
@endsection
