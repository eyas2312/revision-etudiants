@extends('layouts.app')

@section('titre', 'Nouvelle matière')

@section('contenu')
    <h1 class="h3 mb-4">Nouvelle matière</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('admin.matieres.store') }}">
            @csrf
            @include('admin.matieres._form')
        </form>
    </div></div>
@endsection
