<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adapte la table « users » fournie par Laravel au modèle de données du projet :
 * nom, prénom, rôle (enum etudiant|admin). Les colonnes inutilisées sont retirées.
 * Cette migration n'efface aucune donnée existante.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'name') && ! Schema::hasColumn('users', 'nom')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('name', 'nom');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom', 100)->default('')->after('nom');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['etudiant', 'admin'])->default('etudiant')->after('password');
            }
        });

        foreach (['email_verified_at', 'remember_token'] as $colonne) {
            if (Schema::hasColumn('users', $colonne)) {
                Schema::table('users', function (Blueprint $table) use ($colonne) {
                    $table->dropColumn($colonne);
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'role']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nom', 'name');
        });
    }
};
