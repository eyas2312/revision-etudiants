<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InscriptionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('tableau-de-bord');
        }

        return view('auth.inscription');
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $utilisateur = new User([
            'nom' => $donnees['nom'],
            'prenom' => $donnees['prenom'],
            'email' => $donnees['email'],
            'password' => $donnees['password'], // haché par le cast « hashed »
        ]);

        // RG3 : le rôle est fixé par le serveur, jamais lu dans la requête.
        $utilisateur->role = Role::ETUDIANT;
        $utilisateur->save();

        Auth::login($utilisateur);
        $request->session()->regenerate();

        return redirect()->route('tableau-de-bord')
            ->with('success', 'Votre compte a été créé avec succès. Bienvenue !');
    }
}
