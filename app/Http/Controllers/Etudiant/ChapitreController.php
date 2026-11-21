<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use Illuminate\View\View;

class ChapitreController extends Controller
{
    public function show(Chapitre $chapitre): View
    {
        $chapitre->load('matiere');
        abort_if($chapitre->matiere->trashed(), 404);

        $cours = $chapitre->cours()->orderBy('id')->get();
        $quiz = $chapitre->quiz()->disponibles()->withCount('questions')->orderBy('id')->get();

        return view('etudiant.chapitres.show', compact('chapitre', 'cours', 'quiz'));
    }
}
