<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Matiere;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChapitreController extends Controller
{
    private function regles(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'ordre' => ['nullable', 'integer', 'min:1', 'max:65535'],
        ];
    }

    public function create(Matiere $matiere): View
    {
        return view('admin.chapitres.create', [
            'matiere' => $matiere,
            'chapitre' => new Chapitre(['ordre' => ($matiere->chapitres()->max('ordre') ?? 0) + 1]),
        ]);
    }

    public function store(Request $request, Matiere $matiere): RedirectResponse
    {
        $donnees = $request->validate($this->regles());
        $donnees['ordre'] = $donnees['ordre'] ?? (($matiere->chapitres()->max('ordre') ?? 0) + 1);

        $chapitre = $matiere->chapitres()->create($donnees);

        return redirect()->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre créé avec succès.');
    }

    public function show(Chapitre $chapitre): View
    {
        $chapitre->load([
            'matiere',
            'cours' => fn ($q) => $q->orderBy('id'),
            'quiz' => fn ($q) => $q->withCount(['questions', 'tentatives'])->orderBy('id'),
        ]);

        return view('admin.chapitres.show', compact('chapitre'));
    }

    public function edit(Chapitre $chapitre): View
    {
        $chapitre->load('matiere');

        return view('admin.chapitres.edit', compact('chapitre'));
    }

    public function update(Request $request, Chapitre $chapitre): RedirectResponse
    {
        $donnees = $request->validate($this->regles());
        $donnees['ordre'] = $donnees['ordre'] ?? $chapitre->ordre;

        $chapitre->update($donnees);

        return redirect()->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre modifié avec succès.');
    }

    public function confirmerSuppression(Chapitre $chapitre): View
    {
        return view('admin.suppression', [
            'titre' => 'Supprimer le chapitre « '.$chapitre->titre.' »',
            'definitive' => ! $chapitre->aDesTentatives(),
            'contenu' => 'ses cours et quiz',
            'action' => route('admin.chapitres.destroy', $chapitre),
            'retour' => route('admin.chapitres.show', $chapitre),
        ]);
    }

    public function destroy(Chapitre $chapitre): RedirectResponse
    {
        $matiere = $chapitre->matiere;

        try {
            $definitive = $chapitre->supprimerOuArchiver();
        } catch (QueryException) {
            return redirect()->route('admin.chapitres.show', $chapitre)
                ->with('error', 'Suppression impossible : des résultats d\'étudiants sont liés à ce chapitre. Aucune donnée n\'a été perdue.');
        }

        return redirect()->route('admin.matieres.show', $matiere)->with('success', $definitive
            ? 'Chapitre supprimé définitivement.'
            : 'Chapitre archivé : il n\'est plus visible, les résultats des étudiants sont conservés.');
    }
}
