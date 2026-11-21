<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restreint l'accès à un ou plusieurs rôles : EnsureRole::class.':admin'
 * Un visiteur est redirigé vers la connexion (RG4), un rôle incorrect reçoit une erreur 403 (RG6).
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $utilisateur = $request->user();

        if (! $utilisateur) {
            return redirect()->route('login');
        }

        if (! in_array($utilisateur->role?->value, $roles, true)) {
            abort(403, 'Vous n\'avez pas accès à cette page.');
        }

        return $next($request);
    }
}
