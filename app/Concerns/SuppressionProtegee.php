<?php

namespace App\Concerns;

use Illuminate\Support\Facades\DB;

/**
 * RG9 : suppression définitive s'il n'existe aucune tentative,
 * archivage (suppression logique en cascade) dans le cas contraire.
 *
 * Le modèle utilisateur de ce trait doit aussi utiliser SoftDeletes.
 */
trait SuppressionProtegee
{
    /** Vrai si au moins une tentative existe (éléments archivés inclus). */
    abstract public function aDesTentatives(): bool;

    /** Archive l'élément et ses descendants archivables (suppression logique). */
    abstract public function archiver(): void;

    /**
     * @return bool vrai si la suppression est définitive, faux si l'élément a été archivé
     */
    public function supprimerOuArchiver(): bool
    {
        return DB::transaction(function (): bool {
            if ($this->aDesTentatives()) {
                $this->archiver();

                return false;
            }

            $this->forceDelete();

            return true;
        });
    }
}
