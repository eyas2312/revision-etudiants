<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\ConnexionController;
use App\Http\Controllers\Auth\InscriptionController;
use App\Http\Controllers\Etudiant;
use App\Http\Controllers\TableauDeBordController;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sprint 1 : interface et authentification
|--------------------------------------------------------------------------
*/
Route::view('/', 'accueil')->name('accueil');

Route::get('/inscription', [InscriptionController::class, 'create'])->name('inscription');
Route::post('/inscription', [InscriptionController::class, 'store'])->middleware('throttle:20,1')->name('inscription.store');

// La route de connexion s'appelle « login » : c'est le nom attendu par le middleware « auth » de Laravel.
Route::get('/connexion', [ConnexionController::class, 'create'])->name('login');
Route::post('/connexion', [ConnexionController::class, 'authenticate'])->middleware('throttle:10,1')->name('login.store');

Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [ConnexionController::class, 'logout'])->name('deconnexion');
    Route::get('/tableau-de-bord', TableauDeBordController::class)->name('tableau-de-bord');
});

/*
|--------------------------------------------------------------------------
| Administrateur : sprints 2 et 3 (RG6)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', EnsureRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    // Matières
    Route::get('matieres', [Admin\MatiereController::class, 'index'])->name('matieres.index');
    Route::get('matieres/creer', [Admin\MatiereController::class, 'create'])->name('matieres.create');
    Route::post('matieres', [Admin\MatiereController::class, 'store'])->name('matieres.store');
    Route::get('matieres/{matiere}', [Admin\MatiereController::class, 'show'])->name('matieres.show');
    Route::get('matieres/{matiere}/modifier', [Admin\MatiereController::class, 'edit'])->name('matieres.edit');
    Route::put('matieres/{matiere}', [Admin\MatiereController::class, 'update'])->name('matieres.update');
    Route::get('matieres/{matiere}/suppression', [Admin\MatiereController::class, 'confirmerSuppression'])->name('matieres.suppression');
    Route::delete('matieres/{matiere}', [Admin\MatiereController::class, 'destroy'])->name('matieres.destroy');

    // Chapitres
    Route::get('matieres/{matiere}/chapitres/creer', [Admin\ChapitreController::class, 'create'])->name('matieres.chapitres.create');
    Route::post('matieres/{matiere}/chapitres', [Admin\ChapitreController::class, 'store'])->name('matieres.chapitres.store');
    Route::get('chapitres/{chapitre}', [Admin\ChapitreController::class, 'show'])->name('chapitres.show');
    Route::get('chapitres/{chapitre}/modifier', [Admin\ChapitreController::class, 'edit'])->name('chapitres.edit');
    Route::put('chapitres/{chapitre}', [Admin\ChapitreController::class, 'update'])->name('chapitres.update');
    Route::get('chapitres/{chapitre}/suppression', [Admin\ChapitreController::class, 'confirmerSuppression'])->name('chapitres.suppression');
    Route::delete('chapitres/{chapitre}', [Admin\ChapitreController::class, 'destroy'])->name('chapitres.destroy');

    // Cours
    Route::get('chapitres/{chapitre}/cours/creer', [Admin\CoursController::class, 'create'])->name('chapitres.cours.create');
    Route::post('chapitres/{chapitre}/cours', [Admin\CoursController::class, 'store'])->name('chapitres.cours.store');
    Route::get('cours/{cours}', [Admin\CoursController::class, 'show'])->name('cours.show');
    Route::get('cours/{cours}/modifier', [Admin\CoursController::class, 'edit'])->name('cours.edit');
    Route::put('cours/{cours}', [Admin\CoursController::class, 'update'])->name('cours.update');
    Route::delete('cours/{cours}', [Admin\CoursController::class, 'destroy'])->name('cours.destroy');

    // Quiz
    Route::get('quiz', [Admin\QuizController::class, 'index'])->name('quiz.index');
    Route::get('chapitres/{chapitre}/quiz/creer', [Admin\QuizController::class, 'create'])->name('chapitres.quiz.create');
    Route::post('chapitres/{chapitre}/quiz', [Admin\QuizController::class, 'store'])->name('chapitres.quiz.store');
    Route::get('quiz/{quiz}', [Admin\QuizController::class, 'show'])->name('quiz.show');
    Route::get('quiz/{quiz}/modifier', [Admin\QuizController::class, 'edit'])->name('quiz.edit');
    Route::put('quiz/{quiz}', [Admin\QuizController::class, 'update'])->name('quiz.update');
    Route::get('quiz/{quiz}/suppression', [Admin\QuizController::class, 'confirmerSuppression'])->name('quiz.suppression');
    Route::delete('quiz/{quiz}', [Admin\QuizController::class, 'destroy'])->name('quiz.destroy');

    // Questions et réponses
    Route::get('quiz/{quiz}/questions/creer', [Admin\QuestionController::class, 'create'])->name('quiz.questions.create');
    Route::post('quiz/{quiz}/questions', [Admin\QuestionController::class, 'store'])->name('quiz.questions.store');
    Route::get('questions/{question}/modifier', [Admin\QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('questions/{question}', [Admin\QuestionController::class, 'update'])->name('questions.update');
    Route::delete('questions/{question}', [Admin\QuestionController::class, 'destroy'])->name('questions.destroy');
});

/*
|--------------------------------------------------------------------------
| Étudiant : sprints 2 et 3
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', EnsureRole::class.':etudiant'])->name('etudiant.')->group(function () {
    Route::get('matieres', [Etudiant\MatiereController::class, 'index'])->name('matieres.index');
    Route::get('matieres/{matiere}', [Etudiant\MatiereController::class, 'show'])->name('matieres.show');
    Route::get('chapitres/{chapitre}', [Etudiant\ChapitreController::class, 'show'])->name('chapitres.show');
    Route::get('cours/{cours}', [Etudiant\CoursController::class, 'show'])->name('cours.show');

    Route::get('quiz', [Etudiant\QuizController::class, 'index'])->name('quiz.index');
    Route::get('quiz/{quiz}', [Etudiant\QuizController::class, 'show'])->name('quiz.show');
    Route::post('quiz/{quiz}/soumettre', [Etudiant\QuizController::class, 'soumettre'])->name('quiz.soumettre');

    Route::get('resultats', [Etudiant\ResultatController::class, 'index'])->name('resultats.index');
    Route::get('resultats/{tentative}', [Etudiant\ResultatController::class, 'show'])->name('resultats.show');
});
