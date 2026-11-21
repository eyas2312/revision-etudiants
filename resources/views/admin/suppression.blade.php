@extends('layouts.app')

@section('titre', 'Confirmer la suppression')

@section('contenu')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">{{ $titre }}</h1>

                    @if ($definitive)
                        <div class="alert alert-danger">
                            <strong><i class="bi bi-trash3-fill me-1"></i>Suppression définitive.</strong><br>
                            Aucun étudiant n'a de résultat lié à cet élément : il sera supprimé définitivement
                            avec {{ $contenu }}. Cette action est irréversible.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <strong><i class="bi bi-archive-fill me-1"></i>Archivage.</strong><br>
                            Des étudiants ont déjà passé des quiz liés à cet élément : il ne peut pas être supprimé définitivement.
                            Il sera <strong>archivé</strong> avec {{ $contenu }} : il disparaîtra des listes et ne sera plus accessible,
                            mais les résultats et corrections des étudiants seront conservés.
                        </div>
                    @endif

                    <form method="POST" action="{{ $action }}" class="d-flex gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn {{ $definitive ? 'btn-danger' : 'btn-warning' }}">
                            {{ $definitive ? 'Supprimer définitivement' : 'Archiver' }}
                        </button>
                        <a href="{{ $retour }}" class="btn btn-outline-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
