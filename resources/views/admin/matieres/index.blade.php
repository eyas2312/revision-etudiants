@extends('layouts.app')

@section('titre', 'Matières')

@section('contenu')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h1 class="h3 mb-0">Matières</h1>
        <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nouvelle matière</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th class="d-none d-md-table-cell">Description</th>
                        <th class="text-center">Chapitres</th>
                        <th class="text-center">Quiz</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matieres as $matiere)
                        <tr>
                            <td class="fw-semibold"><a href="{{ route('admin.matieres.show', $matiere) }}" class="text-decoration-none">{{ $matiere->nom }}</a></td>
                            <td class="d-none d-md-table-cell text-muted">{{ \Illuminate\Support\Str::limit($matiere->description, 80) }}</td>
                            <td class="text-center">{{ $matiere->chapitres_count }}</td>
                            <td class="text-center">{{ $matiere->quiz_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.matieres.show', $matiere) }}" class="btn btn-sm btn-outline-primary">Ouvrir</a>
                                <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <a href="{{ route('admin.matieres.suppression', $matiere) }}" class="btn btn-sm btn-outline-danger">Supprimer</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune matière pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
