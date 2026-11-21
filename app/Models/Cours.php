<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cours extends Model
{
    /** Nom de table explicite : « cours » est invariable en français. */
    protected $table = 'cours';

    protected $fillable = ['titre', 'contenu'];

    public function chapitre(): BelongsTo
    {
        return $this->belongsTo(Chapitre::class)->withTrashed();
    }
}
