<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\View\View;

class MatiereController extends Controller
{
    /** RG10 : les compteurs sont calculés, les éléments archivés ne sont pas comptés. */
    public function index(): View
    {
        $matieres = Matiere::withCount(['chapitres', 'quiz'])->orderBy('nom')->get();

        return view('etudiant.matieres.index', compact('matieres'));
    }

    public function show(Matiere $matiere): View
    {
        $chapitres = $matiere->chapitres()
            ->withCount(['cours', 'quiz'])
            ->orderBy('ordre')
            ->orderBy('id')
            ->get();

        return view('etudiant.matieres.show', compact('matiere', 'chapitres'));
    }
}
