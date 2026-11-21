<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Cours;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoursController extends Controller
{
    private function regles(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
        ];
    }

    public function create(Chapitre $chapitre): View
    {
        $chapitre->load('matiere');

        return view('admin.cours.create', ['chapitre' => $chapitre, 'cours' => new Cours]);
    }

    public function store(Request $request, Chapitre $chapitre): RedirectResponse
    {
        $cours = $chapitre->cours()->create($request->validate($this->regles()));

        return redirect()->route('admin.cours.show', $cours)->with('success', 'Cours créé avec succès.');
    }

    /** Aperçu du cours tel que l'étudiant le verra. */
    public function show(Cours $cours): View
    {
        $cours->load('chapitre.matiere');

        return view('admin.cours.show', compact('cours'));
    }

    public function edit(Cours $cours): View
    {
        $cours->load('chapitre.matiere');

        return view('admin.cours.edit', compact('cours'));
    }

    public function update(Request $request, Cours $cours): RedirectResponse
    {
        $cours->update($request->validate($this->regles()));

        return redirect()->route('admin.cours.show', $cours)->with('success', 'Cours modifié avec succès.');
    }

    /** Un cours n'a aucune tentative liée : sa suppression est toujours définitive. */
    public function destroy(Cours $cours): RedirectResponse
    {
        $chapitre = $cours->chapitre;
        $cours->delete();

        return redirect()->route('admin.chapitres.show', $chapitre)->with('success', 'Cours supprimé définitivement.');
    }
}
