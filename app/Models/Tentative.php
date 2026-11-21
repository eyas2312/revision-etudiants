<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LogicException;

class Tentative extends Model
{
    /** RG19 : seuil de réussite constant (en pourcentage). */
    public const SEUIL_REUSSITE = 50;

    /** RG15 : une tentative est immuable, pas de colonne updated_at. */
    public const UPDATED_AT = null;

    protected $table = 'tentatives';

    protected $fillable = ['user_id', 'quiz_id', 'score', 'nb_bonnes', 'nb_questions'];

    protected static function booted(): void
    {
        static::updating(function (): void {
            throw new LogicException('Une tentative est immuable et ne peut pas être modifiée (RG15).');
        });

        static::deleting(function (): void {
            throw new LogicException('Une tentative ne peut pas être supprimée (RG15).');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class)->withTrashed();
    }

    public function reponsesTentative(): HasMany
    {
        return $this->hasMany(ReponseTentative::class);
    }

    public function estReussie(): bool
    {
        return (int) $this->score >= self::SEUIL_REUSSITE;
    }

    /** RG19 : statut calculé à partir du score, jamais stocké. */
    protected function statut(): Attribute
    {
        return Attribute::get(fn (): string => $this->estReussie() ? 'Réussi' : 'Non réussi');
    }
}
