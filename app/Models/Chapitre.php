<?php

namespace App\Models;

use App\Concerns\SuppressionProtegee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapitre extends Model
{
    use SoftDeletes, SuppressionProtegee;

    protected $table = 'chapitres';

    protected $fillable = ['titre', 'ordre'];

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class)->withTrashed();
    }

    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }

    public function quiz(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /** Tentatives liées au chapitre, quiz archivés inclus. */
    public function aDesTentatives(): bool
    {
        $quiz = Quiz::withTrashed()->where('chapitre_id', $this->id)->select('id');

        return Tentative::whereIn('quiz_id', $quiz)->exists();
    }

    public function archiver(): void
    {
        foreach ($this->quiz()->get() as $quiz) {
            $quiz->archiver();
        }

        $this->delete();
    }
}
