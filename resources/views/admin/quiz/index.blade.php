@extends('layouts.app')

@section('titre', 'Quiz')

@section('contenu')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h1 class="h3 mb-0">Quiz</h1>
        <span class="text-muted small">Pour créer un quiz, ouvrez un chapitre depuis la page « Matières ».</span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Quiz</th>
                        <th class="d-none d-md-table-cell">Matière › Chapitre</th>
                        <th class="text-center">Questions</th>
                        <th class="text-center">Tentatives</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quiz as $q)
                        <tr>
                            <td class="fw-semibold"><a href="{{ route('admin.quiz.show', $q) }}" class="text-decoration-none">{{ $q->titre }}</a></td>
                            <td class="d-none d-md-table-cell text-muted">{{ $q->chapitre->matiere->nom }} › {{ $q->chapitre->titre }}</td>
                            <td class="text-center">{{ $q->questions_count }}</td>
                            <td class="text-center">{{ $q->tentatives_count }}</td>
                            <td>
                                @if ($q->tentatives_count > 0)
                                    <span class="badge text-bg-warning"><i class="bi bi-lock-fill"></i> Verrouillé</span>
                                @elseif ($q->questions_count === 0)
                                    <span class="badge text-bg-secondary">En préparation</span>
                                @else
                                    <span class="badge text-bg-success">Disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucun quiz pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
