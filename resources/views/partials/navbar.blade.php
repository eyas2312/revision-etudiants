<nav class="navbar navbar-expand-lg navbar-dark navbar-revision shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('accueil') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>Révision Étudiants
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                aria-controls="menuPrincipal" aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tableau-de-bord') ? 'active' : '' }}" href="{{ route('tableau-de-bord') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Tableau de bord
                        </a>
                    </li>
                    @if (auth()->user()->estAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.matieres.*', 'admin.chapitres.*', 'admin.cours.*') ? 'active' : '' }}" href="{{ route('admin.matieres.index') }}">
                                <i class="bi bi-journal-bookmark me-1"></i>Matières
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.quiz.*', 'admin.questions.*') ? 'active' : '' }}" href="{{ route('admin.quiz.index') }}">
                                <i class="bi bi-patch-question me-1"></i>Quiz
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('etudiant.matieres.*', 'etudiant.chapitres.*', 'etudiant.cours.*') ? 'active' : '' }}" href="{{ route('etudiant.matieres.index') }}">
                                <i class="bi bi-journal-bookmark me-1"></i>Matières
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('etudiant.quiz.*') ? 'active' : '' }}" href="{{ route('etudiant.quiz.index') }}">
                                <i class="bi bi-patch-question me-1"></i>Quiz
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('etudiant.resultats.*') ? 'active' : '' }}" href="{{ route('etudiant.resultats.index') }}">
                                <i class="bi bi-bar-chart-line me-1"></i>Mes résultats
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item me-lg-3 text-white-50 small">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nom_complet }}
                        <span class="badge text-bg-light ms-1">{{ auth()->user()->role->libelle() }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('deconnexion') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>Se déconnecter
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item me-lg-2">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="{{ route('inscription') }}">S'inscrire</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
