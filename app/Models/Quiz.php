<?php

namespace App\Models;

use App\Concerns\SuppressionProtegee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes, SuppressionProtegee;

    /** Nom de table explicite (Laravel pluraliserait « quiz » en « quizzes »). */
    protected $table = 'quiz';

    protected $fillable = ['titre'];

    public function chapitre(): BelongsTo
    {
        return $this->belongsTo(Chapitre::class)->withTrashed();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function tentatives(): HasMany
    {
        return $this->hasMany(Tentative::class);
    }

    /** RG12 : quiz non archivé ayant au moins une question (SoftDeletes exclut les archivés). */
    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->whereHas('questions');
    }

    public function aDesTentatives(): bool
    {
        return $this->tentatives()->exists();
    }

    /** RG22 : verrouillé dès la première tentative. */
    public function estVerrouille(): bool
    {
        return $this->aDesTentatives();
    }

    public function estArchive(): bool
    {
        return $this->trashed();
    }

    /** RG12 : disponible = non archivé et au moins une question. */
    public function estDisponible(): bool
    {
        return ! $this->trashed() && $this->questions()->exists();
    }

    public function archiver(): void
    {
        $this->delete();
    }
}
