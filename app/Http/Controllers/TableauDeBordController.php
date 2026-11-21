<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Cours;
use App\Models\Matiere;
use App\Models\Quiz;
use App\Models\Tentative;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TableauDeBordController extends Controller
{
    public function __invoke(Request $request): View
    {
        $utilisateur = $request->user();

        if ($utilisateur->estAdmin()) {
            return view('dashboard.admin', [
                'stats' => [
                    'Matières' => Matiere::count(),
                    'Chapitres' => Chapitre::count(),
                    'Cours' => Cours::count(),
                    'Quiz' => Quiz::count(),
                    'Étudiants' => User::where('role', 'etudiant')->count(),
                    'Tentatives' => Tentative::count(),
                ],
            ]);
        }

        return view('dashboard.etudiant', [
            'dernieresTentatives' => $utilisateur->tentatives()
                ->with('quiz')
                ->latest('created_at')
                ->latest('id')
                ->limit(3)
                ->get(),
        ]);
    }
}
