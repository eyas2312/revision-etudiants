<?php

namespace App\Models;

use App\Enums\TypeQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['enonce', 'type', 'explication'];

    protected function casts(): array
    {
        return ['type' => TypeQuestion::class];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class)->withTrashed();
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(Reponse::class);
    }

    public function reponseCorrecte(): HasOne
    {
        return $this->hasOne(Reponse::class)->where('est_correcte', true);
    }
}
