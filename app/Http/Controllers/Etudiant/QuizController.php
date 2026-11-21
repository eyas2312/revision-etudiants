<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\ScoreService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    /** US16 : quiz disponibles (RG12), regroupés par matière et chapitre. */
    public function index(): View
    {
        $groupes = Quiz::disponibles()
            ->with('chapitre.matiere')
            ->withCount('questions')
            ->orderBy('titre')
            ->get()
            ->groupBy(fn (Quiz $quiz) => $quiz->chapitre->matiere->nom.' › '.$quiz->chapitre->titre)
            ->sortKeys();

        return view('etudiant.quiz.index', compact('groupes'));
    }

    /** US17 : les bonnes réponses ne sont jamais envoyées au navigateur (BNF4). */
    public function show(Quiz $quiz): View
    {
        abort_unless($quiz->estDisponible(), 404);

        $quiz->load([
            'chapitre.matiere',
            'questions' => fn ($q) => $q->orderBy('id'),
            'questions.reponses' => fn ($r) => $r->select('id', 'question_id', 'libelle')->orderBy('id'),
        ]);

        return view('etudiant.quiz.show', compact('quiz'));
    }

    public function soumettre(Request $request, Quiz $quiz, ScoreService $service): RedirectResponse
    {
        try {
            $tentative = $service->corriger($request->user(), $quiz, (array) $request->input('choix', []));
        } catch (DomainException $e) {
            return redirect()->route('etudiant.quiz.index')->with('error', $e->getMessage());
        }

        return redirect()->route('etudiant.resultats.show', $tentative)
            ->with('success', 'Quiz terminé : voici votre résultat.');
    }
}
