<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\View\View;

class CoursController extends Controller
{
    public function show(Cours $cours): View
    {
        $cours->load('chapitre.matiere');

        // Un cours d'un chapitre ou d'une matière archivés n'est plus accessible.
        abort_if($cours->chapitre->trashed() || $cours->chapitre->matiere->trashed(), 404);

        return view('etudiant.cours.show', compact('cours'));
    }
}
