<?php

namespace App\Http\Requests;

use App\Enums\TypeQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

/**
 * Validation d'une question de quiz (QCM ou vrai/faux) et de ses réponses.
 *
 * Formulaire QCM : reponses[clé] = libellé, correcte = clé de la bonne réponse.
 * Formulaire vrai/faux : correcte_vf = « vrai » ou « faux ».
 */
class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // L'accès est déjà restreint aux administrateurs par le middleware de rôle.
        return true;
    }

    private function estQcm(): bool
    {
        return $this->input('type') === TypeQuestion::QCM->value;
    }

    private function estVraiFaux(): bool
    {
        return $this->input('type') === TypeQuestion::VRAI_FAUX->value;
    }

    public function rules(): array
    {
        $qcm = $this->estQcm();

        return [
            'enonce' => ['required', 'string'],
            'type' => ['required', new Enum(TypeQuestion::class)],
            'explication' => ['nullable', 'string'],
            'reponses' => $qcm ? ['required', 'array', 'min:2'] : ['nullable', 'array'],
            'reponses.*' => $qcm ? ['required', 'string', 'max:255'] : ['nullable'],
            'correcte' => $qcm ? ['required'] : ['nullable'],
            'correcte_vf' => $this->estVraiFaux() ? ['required', Rule::in(['vrai', 'faux'])] : ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'reponses.required' => 'Ajoutez au moins deux réponses.',
            'reponses.min' => 'Une question QCM doit proposer au moins deux réponses.',
            'reponses.*.required' => 'Chaque réponse doit être renseignée (ou supprimée).',
            'correcte.required' => 'Sélectionnez la bonne réponse.',
            'correcte_vf.required' => 'Indiquez si l\'affirmation est vraie ou fausse.',
            'correcte_vf.in' => 'Indiquez si l\'affirmation est vraie ou fausse.',
        ];
    }

    /** RG11 : une seule bonne réponse, qui doit appartenir à la liste proposée. */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (! $this->estQcm() || $validator->errors()->has('reponses') || $validator->errors()->has('correcte')) {
                    return;
                }

                $reponses = (array) $this->input('reponses', []);

                if (! array_key_exists((string) $this->input('correcte'), $reponses)) {
                    $validator->errors()->add('correcte', 'Sélectionnez la bonne réponse parmi celles proposées.');
                }
            },
        ];
    }

    /**
     * Réponses à enregistrer, normalisées : [['libelle' => ..., 'est_correcte' => bool], ...].
     *
     * @return array<int, array{libelle: string, est_correcte: bool}>
     */
    public function reponsesAEnregistrer(): array
    {
        if ($this->estVraiFaux()) {
            $vrai = $this->input('correcte_vf') === 'vrai';

            return [
                ['libelle' => 'Vrai', 'est_correcte' => $vrai],
                ['libelle' => 'Faux', 'est_correcte' => ! $vrai],
            ];
        }

        $resultat = [];
        foreach ((array) $this->input('reponses', []) as $cle => $libelle) {
            $resultat[] = [
                'libelle' => trim((string) $libelle),
                'est_correcte' => (string) $cle === (string) $this->input('correcte'),
            ];
        }

        return $resultat;
    }
}
