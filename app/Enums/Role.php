<?php

namespace App\Enums;

enum Role: string
{
    case ETUDIANT = 'etudiant';
    case ADMIN = 'admin';

    public function libelle(): string
    {
        return match ($this) {
            self::ETUDIANT => 'Étudiant',
            self::ADMIN => 'Administrateur',
        };
    }
}
