<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reponse_tentatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tentative_id')->constrained('tentatives')->restrictOnDelete();
            $table->foreignId('question_id')->constrained('questions')->restrictOnDelete();
            // NULL = question laissée sans réponse (RG14).
            $table->foreignId('reponse_id')->nullable()->constrained('reponses')->restrictOnDelete();
            $table->boolean('est_correcte');
            $table->timestamp('created_at')->useCurrent();

            // Un seul détail par question et par tentative.
            $table->unique(['tentative_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reponse_tentatives');
    }
};
