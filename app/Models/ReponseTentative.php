<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LogicException;

/** Détail d'une tentative : réponse choisie (ou aucune) pour une question. */
class ReponseTentative extends Model
{
    /** RG15 : immuable, pas de colonne updated_at. */
    public const UPDATED_AT = null;

    protected $table = 'reponse_tentatives';

    protected $fillable = ['question_id', 'reponse_id', 'est_correcte'];

    protected function casts(): array
    {
        return ['est_correcte' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::updating(function (): void {
            throw new LogicException('Le détail d\'une tentative est immuable (RG15).');
        });

        static::deleting(function (): void {
            throw new LogicException('Le détail d\'une tentative ne peut pas être supprimé (RG15).');
        });
    }

    public function tentative(): BelongsTo
    {
        return $this->belongsTo(Tentative::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /** Réponse choisie par l'étudiant (nulle si la question est restée sans réponse, RG14). */
    public function reponseChoisie(): BelongsTo
    {
        return $this->belongsTo(Reponse::class, 'reponse_id');
    }
}
