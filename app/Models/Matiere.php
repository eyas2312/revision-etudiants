<?php

namespace App\Models;

use App\Concerns\SuppressionProtegee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matiere extends Model
{
    use SoftDeletes, SuppressionProtegee;

    protected $table = 'matieres';

    protected $fillable = ['nom', 'description'];

    public function chapitres(): HasMany
    {
        return $this->hasMany(Chapitre::class);
    }

    /** Quiz non archivés de la matière (via ses chapitres). */
    public function quiz(): HasManyThrough
    {
        return $this->hasManyThrough(Quiz::class, Chapitre::class);
    }

    /** Tentatives liées à la matière, chapitres et quiz archivés inclus. */
    public function aDesTentatives(): bool
    {
        $chapitres = Chapitre::withTrashed()->where('matiere_id', $this->id)->select('id');
        $quiz = Quiz::withTrashed()->whereIn('chapitre_id', $chapitres)->select('id');

        return Tentative::whereIn('quiz_id', $quiz)->exists();
    }

    public function archiver(): void
    {
        foreach ($this->chapitres()->get() as $chapitre) {
            $chapitre->archiver();
        }

        $this->delete();
    }
}
