<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapitres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id')->constrained('matieres')->cascadeOnDelete();
            $table->string('titre', 255);
            $table->unsignedSmallInteger('ordre')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['matiere_id', 'ordre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapitres');
    }
};
