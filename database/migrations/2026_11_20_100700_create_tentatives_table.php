<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentatives', function (Blueprint $table) {
            $table->id();
            // RG15 : toutes les clés étrangères vers les tentatives sont en RESTRICT.
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('quiz_id')->constrained('quiz')->restrictOnDelete();
            $table->unsignedTinyInteger('score');
            $table->unsignedSmallInteger('nb_bonnes');
            $table->unsignedSmallInteger('nb_questions');
            // Date de soumission. Pas de updated_at : la tentative est immuable.
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tentatives');
    }
};
