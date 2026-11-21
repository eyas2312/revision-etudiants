<?php

namespace App\Enums;

enum TypeQuestion: string
{
    case QCM = 'qcm';
    case VRAI_FAUX = 'vrai_faux';

    public function libelle(): string
    {
        return match ($this) {
            self::QCM => 'QCM',
            self::VRAI_FAUX => 'Vrai / Faux',
        };
    }
}
