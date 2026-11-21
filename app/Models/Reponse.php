<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Option proposée pour une question (à ne pas confondre avec ReponseTentative). */
class Reponse extends Model
{
    protected $table = 'reponses';

    protected $fillable = ['libelle', 'est_correcte'];

    protected function casts(): array
    {
        return ['est_correcte' => 'boolean'];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
