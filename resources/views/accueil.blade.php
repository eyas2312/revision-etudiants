@extends('layouts.app')

@section('titre', 'Accueil')

@section('hero')
    <section class="hero text-white">
        <div class="container py-5">
            <div class="row align-items-center py-lg-4">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-3">Révisez efficacement,<br>mesurez votre niveau.</h1>
                    <p class="lead mb-4">
                        Retrouvez vos cours par matière et par chapitre, entraînez-vous avec des quiz,
                        obtenez votre score instantanément et comprenez vos erreurs grâce aux corrections.
                    </p>
                    @auth
                        <a href="{{ route('tableau-de-bord') }}" class="btn btn-light btn-lg me-2">
                            <i class="bi bi-speedometer2 me-1"></i>Accéder à mon tableau de bord
                        </a>
                    @else
                        <a href="{{ route('inscription') }}" class="btn btn-light btn-lg me-2 mb-2">
                            <i class="bi bi-person-plus me-1"></i>Créer un compte
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg mb-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                        </a>
                    @endauth
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <i class="bi bi-mortarboard hero-icon"></i>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('contenu')
    <section class="py-3">
        <h2 class="h3 text-center mb-4">Tout pour réviser au même endroit</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center carte-fonction">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark-fill display-5 text-primary"></i>
                        <h3 class="h5 mt-3">Cours organisés</h3>
                        <p class="text-muted mb-0">Matières, chapitres et cours classés pour réviser un point précis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center carte-fonction">
                    <div class="card-body">
                        <i class="bi bi-patch-question-fill display-5 text-primary"></i>
                        <h3 class="h5 mt-3">Quiz d'entraînement</h3>
                        <p class="text-muted mb-0">QCM et questions vrai/faux pour tester vos connaissances.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center carte-fonction">
                    <div class="card-body">
                        <i class="bi bi-speedometer display-5 text-primary"></i>
                        <h3 class="h5 mt-3">Score automatique</h3>
                        <p class="text-muted mb-0">Un pourcentage et un statut « Réussi » dès la fin du quiz.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center carte-fonction">
                    <div class="card-body">
                        <i class="bi bi-lightbulb-fill display-5 text-primary"></i>
                        <h3 class="h5 mt-3">Corrections détaillées</h3>
                        <p class="text-muted mb-0">Visualisez vos erreurs et lisez les explications pour progresser.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <h2 class="h3 text-center mb-4">Comment ça marche ?</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <span class="etape">1</span>
                <h3 class="h5 mt-2">Inscrivez-vous</h3>
                <p class="text-muted">Créez votre compte étudiant en quelques secondes.</p>
            </div>
            <div class="col-md-4">
                <span class="etape">2</span>
                <h3 class="h5 mt-2">Révisez vos cours</h3>
                <p class="text-muted">Parcourez les matières et lisez les cours de chaque chapitre.</p>
            </div>
            <div class="col-md-4">
                <span class="etape">3</span>
                <h3 class="h5 mt-2">Passez un quiz</h3>
                <p class="text-muted">Obtenez votre score, consultez les corrections et recommencez pour progresser.</p>
            </div>
        </div>
    </section>
@endsection
