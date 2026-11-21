<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Quiz;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    private const MESSAGE_VERROUILLE = 'Ce quiz a déjà été passé par des étudiants : il est verrouillé et ne peut plus être modifié. '
        .'Créez un nouveau quiz ou archivez celui-ci.';

    public function index(): View
    {
        $quiz = Quiz::with('chapitre.matiere')
            ->withCount(['questions', 'tentatives'])
            ->orderByDesc('id')
            ->get();

        return view('admin.quiz.index', compact('quiz'));
    }

    public function create(Chapitre $chapitre): View
    {
        $chapitre->load('matiere');

        return view('admin.quiz.create', ['chapitre' => $chapitre, 'quiz' => new Quiz]);
    }

    public function store(Request $request, Chapitre $chapitre): RedirectResponse
    {
        $donnees = $request->validate(['titre' => ['required', 'string', 'max:255']]);

        $quiz = $chapitre->quiz()->create($donnees);

        return redirect()->route('admin.quiz.show', $quiz)
            ->with('success', 'Quiz créé. Ajoutez maintenant ses questions.');
    }

    public function show(Quiz $quiz): View
    {
        $quiz->load(['chapitre.matiere', 'questions' => fn ($q) => $q->orderBy('id'), 'questions.reponses' => fn ($r) => $r->orderBy('id')]);
        $quiz->loadCount('tentatives');

        return view('admin.quiz.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View|RedirectResponse
    {
        if ($quiz->estVerrouille()) {
            return redirect()->route('admin.quiz.show', $quiz)->with('error', self::MESSAGE_VERROUILLE);
        }

        $quiz->load('chapitre.matiere');

        return view('admin.quiz.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        // RG22 : un quiz verrouillé ne peut plus être modifié.
        if ($quiz->estVerrouille()) {
            return redirect()->route('admin.quiz.show', $quiz)->with('error', self::MESSAGE_VERROUILLE);
        }

        $quiz->update($request->validate(['titre' => ['required', 'string', 'max:255']]));

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Quiz modifié avec succès.');
    }

    public function confirmerSuppression(Quiz $quiz): View
    {
        return view('admin.suppression', [
            'titre' => 'Supprimer le quiz « '.$quiz->titre.' »',
            'definitive' => ! $quiz->aDesTentatives(),
            'contenu' => 'ses questions et réponses',
            'action' => route('admin.quiz.destroy', $quiz),
            'retour' => route('admin.quiz.show', $quiz),
        ]);
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $chapitre = $quiz->chapitre;

        try {
            $definitive = $quiz->supprimerOuArchiver();
        } catch (QueryException) {
            return redirect()->route('admin.quiz.show', $quiz)
                ->with('error', 'Suppression impossible : des résultats d\'étudiants sont liés à ce quiz. Aucune donnée n\'a été perdue.');
        }

        return redirect()->route('admin.chapitres.show', $chapitre)->with('success', $definitive
            ? 'Quiz supprimé définitivement.'
            : 'Quiz archivé : il n\'est plus proposé aux étudiants, leurs résultats sont conservés.');
    }
}
