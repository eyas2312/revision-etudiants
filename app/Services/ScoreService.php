<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Tentative;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

/**
 * Corrige un quiz et enregistre la tentative (US18).
 * Tout se fait dans une seule transaction : tout ou rien.
 */
class ScoreService
{
    /**
     * @param  array<int|string, mixed>  $choix  [id_question => id_reponse_choisie]
     *
     * @throws DomainException si le quiz est indisponible ou la soumission incohérente
     */
    public function corriger(User $utilisateur, Quiz $quiz, array $choix): Tentative
    {
        return DB::transaction(function () use ($utilisateur, $quiz, $choix): Tentative {
            // Relecture de l'état actuel du quiz (un quiz archivé n'est plus retrouvé).
            $quizActuel = Quiz::query()->find($quiz->id);

            if (! $quizActuel || ! $quizActuel->estDisponible()) {
                throw new DomainException('Ce quiz n\'est plus disponible. Veuillez recommencer depuis la liste des quiz.');
            }

            $questions = $quizActuel->questions()->with('reponses')->orderBy('id')->get();

            $this->verifierCoherence($questions->all(), $choix);

            $details = [];
            $nbBonnes = 0;

            foreach ($questions as $question) {
                $brut = $choix[$question->id] ?? null;
                $reponseId = ($brut === null || $brut === '') ? null : (int) $brut;

                $choisie = $reponseId === null ? null : $question->reponses->firstWhere('id', $reponseId);

                // RG14 : sans réponse = incorrect.
                $estCorrecte = $choisie !== null && $choisie->est_correcte === true;

                if ($estCorrecte) {
                    $nbBonnes++;
                }

                $details[] = [
                    'question_id' => $question->id,
                    'reponse_id' => $reponseId,
                    'est_correcte' => $estCorrecte,
                ];
            }

            $nbQuestions = $questions->count();

            // RG13 : pourcentage arrondi à l'entier le plus proche.
            $score = (int) round($nbBonnes / $nbQuestions * 100);

            $tentative = Tentative::create([
                'user_id' => $utilisateur->id,
                'quiz_id' => $quizActuel->id,
                'score' => $score,
                'nb_bonnes' => $nbBonnes,
                'nb_questions' => $nbQuestions,
            ]);

            $tentative->reponsesTentative()->createMany($details);

            return $tentative;
        });
    }

    /**
     * Les questions et réponses soumises doivent appartenir au quiz tel qu'il est maintenant.
     *
     * @param  array<int, Question>  $questions
     * @param  array<int|string, mixed>  $choix
     */
    private function verifierCoherence(array $questions, array $choix): void
    {
        $parId = [];
        foreach ($questions as $question) {
            $parId[$question->id] = $question;
        }

        foreach ($choix as $questionId => $reponseId) {
            if (! isset($parId[(int) $questionId])) {
                throw new DomainException('Le quiz a été modifié pendant votre session. Veuillez le recommencer.');
            }

            if ($reponseId === null || $reponseId === '') {
                continue;
            }

            if (! is_scalar($reponseId) || ! $parId[(int) $questionId]->reponses->contains('id', (int) $reponseId)) {
                throw new DomainException('Réponse invalide : veuillez recommencer le quiz.');
            }
        }
    }
}
