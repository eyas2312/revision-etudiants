<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Tentative;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultatController extends Controller
{
    /** US20 : historique des tentatives de l'étudiant connecté (quiz archivés inclus). */
    public function index(Request $request): View
    {
        $tentatives = $request->user()->tentatives()
            ->with('quiz.chapitre.matiere')
            ->latest('created_at')
            ->latest('id')
            ->get();

        return view('etudiant.resultats.index', compact('tentatives'));
    }

    /** US18/US19 : résultat et corrections d'une tentative. */
    public function show(Request $request, Tentative $tentative): View
    {
        // RG18 : un étudiant ne consulte que ses propres résultats.
        abort_unless((int) $tentative->user_id === (int) $request->user()->id, 403);

        $tentative->load([
            'quiz.chapitre.matiere',
            'reponsesTentative' => fn ($q) => $q->orderBy('id'),
            'reponsesTentative.question.reponses',
            'reponsesTentative.reponseChoisie',
        ]);

        return view('etudiant.resultats.show', compact('tentative'));
    }
}
