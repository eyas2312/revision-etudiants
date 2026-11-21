<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MatiereController extends Controller
{
    public function index(): View
    {
        $matieres = Matiere::withCount(['chapitres', 'quiz'])->orderBy('nom')->get();

        return view('admin.matieres.index', compact('matieres'));
    }

    public function create(): View
    {
        return view('admin.matieres.create', ['matiere' => new Matiere]);
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:150', 'unique:matieres,nom'],
            'description' => ['nullable', 'string'],
        ]);

        $matiere = Matiere::create($donnees);

        return redirect()->route('admin.matieres.show', $matiere)
            ->with('success', 'Matière créée avec succès.');
    }

    public function show(Matiere $matiere): View
    {
        $matiere->loadCount(['chapitres', 'quiz']);
        $chapitres = $matiere->chapitres()
            ->withCount(['cours', 'quiz'])
            ->orderBy('ordre')
            ->orderBy('id')
            ->get();

        return view('admin.matieres.show', compact('matiere', 'chapitres'));
    }

    public function edit(Matiere $matiere): View
    {
        return view('admin.matieres.edit', compact('matiere'));
    }

    public function update(Request $request, Matiere $matiere): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:150', Rule::unique('matieres', 'nom')->ignore($matiere->id)],
            'description' => ['nullable', 'string'],
        ]);

        $matiere->update($donnees);

        return redirect()->route('admin.matieres.show', $matiere)
            ->with('success', 'Matière modifiée avec succès.');
    }

    /** RG9f : la confirmation indique si l'action sera une suppression ou un archivage. */
    public function confirmerSuppression(Matiere $matiere): View
    {
        return view('admin.suppression', [
            'titre' => 'Supprimer la matière « '.$matiere->nom.' »',
            'definitive' => ! $matiere->aDesTentatives(),
            'contenu' => 'ses chapitres, cours et quiz',
            'action' => route('admin.matieres.destroy', $matiere),
            'retour' => route('admin.matieres.show', $matiere),
        ]);
    }

    public function destroy(Matiere $matiere): RedirectResponse
    {
        try {
            $definitive = $matiere->supprimerOuArchiver();
        } catch (QueryException) {
            return redirect()->route('admin.matieres.show', $matiere)
                ->with('error', 'Suppression impossible : des résultats d\'étudiants sont liés à cette matière. Aucune donnée n\'a été perdue.');
        }

        return redirect()->route('admin.matieres.index')->with('success', $definitive
            ? 'Matière supprimée définitivement.'
            : 'Matière archivée : elle n\'est plus visible, les résultats des étudiants sont conservés.');
    }
}
