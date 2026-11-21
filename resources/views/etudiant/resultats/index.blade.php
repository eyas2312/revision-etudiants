@extends('layouts.app')

@section('titre', 'Mes résultats')

@section('contenu')
    <h1 class="h3 mb-4">Mes résultats</h1>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Quiz</th>
                        <th class="d-none d-md-table-cell">Matière › Chapitre</th>
                        <th>Date</th>
                        <th class="text-center">Score</th>
                        <th>Statut</th>
                        <th class="text-end">Correction</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tentatives as $tentative)
                        <tr>
                            <td class="fw-semibold">
                                {{ $tentative->quiz->titre }}
                                @if ($tentative->quiz->trashed())
                                    <span class="badge text-bg-secondary ms-1">Archivé</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell text-muted">{{ $tentative->quiz->chapitre->matiere->nom }} › {{ $tentative->quiz->chapitre->titre }}</td>
                            <td class="text-nowrap">{{ $tentative->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center"><strong>{{ $tentative->score }} %</strong> <small class="text-muted">({{ $tentative->nb_bonnes }}/{{ $tentative->nb_questions }})</small></td>
                            <td><span class="badge {{ $tentative->estReussie() ? 'text-bg-success' : 'text-bg-danger' }}">{{ $tentative->statut }}</span></td>
                            <td class="text-end"><a href="{{ route('etudiant.resultats.show', $tentative) }}" class="btn btn-sm btn-outline-primary">Voir la correction</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Vous n'avez pas encore passé de quiz.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
