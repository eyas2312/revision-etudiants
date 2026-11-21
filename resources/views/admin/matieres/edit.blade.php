@extends('layouts.app')

@section('titre', 'Modifier la matière')

@section('contenu')
    <h1 class="h3 mb-4">Modifier la matière « {{ $matiere->nom }} »</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.matieres.update', $matiere) }}">
            @csrf
            @method('PUT')
            @include('admin.matieres._form')
        </form>
    </div></div>
@endsection
