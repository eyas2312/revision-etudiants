<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\TypeQuestion;
use App\Models\Chapitre;
use App\Models\Matiere;
use App\Models\Quiz;
use App\Models\User;
use App\Services\ScoreService;
use Illuminate\Database\Seeder;

/**
 * Données de démonstration. Le seeder est idempotent : il peut être relancé
 * sans créer de doublons et ne supprime jamais de données.
 *
 * Comptes créés :
 *   admin@revision.test     / Admin1234!
 *   etudiant@revision.test  / Etudiant1234!
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->utilisateur('admin@revision.test', 'Revision', 'Admin', 'Admin1234!', Role::ADMIN);
        $etudiant = $this->utilisateur('etudiant@revision.test', 'Ben Salah', 'Amine', 'Etudiant1234!', Role::ETUDIANT);

        $web = Matiere::firstOrCreate(
            ['nom' => 'Développement Web'],
            ['description' => 'Les fondamentaux de la création de pages et d\'applications web.']
        );
        $bdd = Matiere::firstOrCreate(
            ['nom' => 'Bases de données'],
            ['description' => 'Concevoir, interroger et manipuler des bases de données relationnelles.']
        );

        $html = $this->chapitre($web, 'Introduction à HTML', 1);
        $css = $this->chapitre($web, 'Mise en forme avec CSS', 2);
        $sql = $this->chapitre($bdd, 'Le langage SQL', 1);

        $this->cours($html, 'Structure d\'une page HTML', <<<'TXT'
Une page HTML est un document texte composé de balises.

La structure minimale comprend :
- la déclaration <!DOCTYPE html> qui indique le type de document ;
- l'élément <html> qui contient toute la page ;
- l'élément <head> qui regroupe les informations sur la page (titre, encodage) ;
- l'élément <body> qui contient le contenu visible.

Exemple : un titre principal s'écrit avec la balise <h1> et un paragraphe avec la balise <p>.
TXT);
        $this->cours($html, 'Liens, images et listes', <<<'TXT'
Un lien hypertexte se crée avec la balise <a> et son attribut href.
Une image s'insère avec la balise <img> et ses attributs src et alt.
Une liste à puces utilise <ul> et une liste numérotée <ol> ; chaque élément est placé dans une balise <li>.
TXT);
        $this->cours($css, 'Sélecteurs et propriétés', <<<'TXT'
Une règle CSS associe un sélecteur à des déclarations.
Le sélecteur désigne les éléments à mettre en forme (par balise, par classe avec un point, par identifiant avec un dièse).
Chaque déclaration est composée d'une propriété et d'une valeur, par exemple color: blue;
TXT);
        $this->cours($sql, 'Interroger une table avec SELECT', <<<'TXT'
La commande SELECT permet de lire des données.
SELECT nom, email FROM etudiants WHERE actif = 1 ORDER BY nom;
La clause WHERE filtre les lignes, la clause ORDER BY trie le résultat.
TXT);

        $quizHtml = $this->quiz($html, 'Les bases de HTML', [
            [
                'enonce' => 'Quelle balise contient le contenu visible d\'une page HTML ?',
                'type' => TypeQuestion::QCM,
                'explication' => 'La balise <body> contient tout ce qui s\'affiche dans le navigateur ; <head> regroupe les métadonnées.',
                'reponses' => [['<body>', true], ['<head>', false], ['<title>', false]],
            ],
            [
                'enonce' => 'Quelle balise permet de créer un lien hypertexte ?',
                'type' => TypeQuestion::QCM,
                'explication' => 'La balise <a> avec son attribut href crée un lien.',
                'reponses' => [['<a>', true], ['<link>', false], ['<href>', false]],
            ],
            [
                'enonce' => 'L\'attribut alt d\'une image fournit un texte alternatif.',
                'type' => TypeQuestion::VRAI_FAUX,
                'explication' => 'Le texte alternatif est affiché si l\'image ne charge pas et lu par les lecteurs d\'écran.',
                'reponses' => [['Vrai', true], ['Faux', false]],
            ],
            [
                'enonce' => 'La balise <ul> crée une liste numérotée.',
                'type' => TypeQuestion::VRAI_FAUX,
                'explication' => '<ul> crée une liste à puces ; la liste numérotée utilise <ol>.',
                'reponses' => [['Vrai', false], ['Faux', true]],
            ],
            [
                'enonce' => 'Quelle déclaration indique le type de document HTML5 ?',
                'type' => TypeQuestion::QCM,
                'explication' => 'La déclaration <!DOCTYPE html> se place tout en haut du document.',
                'reponses' => [['<!DOCTYPE html>', true], ['<html5>', false], ['<doc type="html">', false]],
            ],
        ]);

        $this->quiz($sql, 'Introduction à SQL', [
            [
                'enonce' => 'Quelle commande SQL permet de lire des données ?',
                'type' => TypeQuestion::QCM,
                'explication' => 'SELECT lit les données ; INSERT les ajoute, UPDATE les modifie.',
                'reponses' => [['SELECT', true], ['INSERT', false], ['UPDATE', false]],
            ],
            [
                'enonce' => 'La clause WHERE sert à filtrer les lignes d\'un résultat.',
                'type' => TypeQuestion::VRAI_FAUX,
                'explication' => 'WHERE conserve uniquement les lignes qui respectent la condition.',
                'reponses' => [['Vrai', true], ['Faux', false]],
            ],
            [
                'enonce' => 'Quelle clause permet de trier le résultat d\'une requête ?',
                'type' => TypeQuestion::QCM,
                'explication' => 'ORDER BY trie le résultat selon une ou plusieurs colonnes.',
                'reponses' => [['ORDER BY', true], ['GROUP BY', false], ['LIMIT', false]],
            ],
        ]);

        // Une tentative de démonstration (3 bonnes réponses sur 5) pour illustrer
        // l'historique et le verrouillage d'un quiz (RG22).
        if ($quizHtml && ! $etudiant->tentatives()->exists()) {
            $questions = $quizHtml->questions()->with('reponses')->orderBy('id')->get();
            $choix = [];

            foreach ($questions as $i => $question) {
                $cible = $question->reponses->first(
                    fn ($reponse) => $i < 3 ? $reponse->est_correcte : ! $reponse->est_correcte
                );
                $choix[$question->id] = $cible->id;
            }

            app(ScoreService::class)->corriger($etudiant, $quizHtml, $choix);
        }
    }

    private function utilisateur(string $email, string $nom, string $prenom, string $motDePasse, Role $role): User
    {
        $utilisateur = User::where('email', $email)->first();

        if ($utilisateur) {
            return $utilisateur;
        }

        $utilisateur = new User(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'password' => $motDePasse]);
        $utilisateur->role = $role;
        $utilisateur->save();

        return $utilisateur;
    }

    private function chapitre(Matiere $matiere, string $titre, int $ordre): Chapitre
    {
        return $matiere->chapitres()->firstOrCreate(['titre' => $titre], ['ordre' => $ordre]);
    }

    private function cours(Chapitre $chapitre, string $titre, string $contenu): void
    {
        $chapitre->cours()->firstOrCreate(['titre' => $titre], ['contenu' => $contenu]);
    }

    /**
     * Crée le quiz et ses questions seulement s'il vient d'être créé.
     *
     * @param  array<int, array<string, mixed>>  $questions
     */
    private function quiz(Chapitre $chapitre, string $titre, array $questions): ?Quiz
    {
        $quiz = $chapitre->quiz()->firstOrCreate(['titre' => $titre]);

        if ($quiz->wasRecentlyCreated) {
            foreach ($questions as $donnees) {
                $question = $quiz->questions()->create([
                    'enonce' => $donnees['enonce'],
                    'type' => $donnees['type']->value,
                    'explication' => $donnees['explication'] ?? null,
                ]);

                foreach ($donnees['reponses'] as [$libelle, $estCorrecte]) {
                    $question->reponses()->create(['libelle' => $libelle, 'est_correcte' => $estCorrecte]);
                }
            }
        }

        return $quiz;
    }
}
