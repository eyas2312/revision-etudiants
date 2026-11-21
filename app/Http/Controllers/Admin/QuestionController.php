<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionController extends Controller
{
    private const MESSAGE_VERROUILLE = 'Ce quiz a déjà été passé par des étudiants : il est verrouillé, '
        .'ses questions et réponses ne peuvent plus être ajoutées, modifiées ni supprimées (RG22).';

    private function refus(Quiz $quiz): RedirectResponse
    {
        return redirect()->route('admin.quiz.show', $quiz)->with('error', self::MESSAGE_VERROUILLE);
    }

    public function create(Quiz $quiz): View|RedirectResponse
    {
        if ($quiz->estVerrouille()) {
            return $this->refus($quiz);
        }

        return view('admin.questions.create', ['quiz' => $quiz, 'question' => new Question]);
    }

    public function store(QuestionRequest $request, Quiz $quiz): RedirectResponse
    {
        if ($quiz->estVerrouille()) {
            return $this->refus($quiz);
        }

        DB::transaction(function () use ($request, $quiz): void {
            $question = $quiz->questions()->create($request->safe()->only(['enonce', 'type', 'explication']));
            $question->reponses()->createMany($request->reponsesAEnregistrer());
        });

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Question ajoutée avec succès.');
    }

    public function edit(Question $question): View|RedirectResponse
    {
        $quiz = $question->quiz;

        if ($quiz->estVerrouille()) {
            return $this->refus($quiz);
        }

        $question->load(['reponses' => fn ($r) => $r->orderBy('id')]);

        return view('admin.questions.edit', compact('question', 'quiz'));
    }

    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $quiz = $question->quiz;

        if ($quiz->estVerrouille()) {
            return $this->refus($quiz);
        }

        DB::transaction(function () use ($request, $question): void {
            $question->update($request->safe()->only(['enonce', 'type', 'explication']));

            // Aucune tentative n'existe (quiz non verrouillé) : on peut remplacer les réponses.
            $question->reponses()->delete();
            $question->reponses()->createMany($request->reponsesAEnregistrer());
        });

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Question modifiée avec succès.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $quiz = $question->quiz;

        if ($quiz->estVerrouille()) {
            return $this->refus($quiz);
        }

        $question->delete();

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Question supprimée.');
    }
}
