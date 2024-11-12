<?php

namespace App\Services;

use App\Models\User;

class EmailSenderService
{
    public function send(User $user)
    {
        // Simule l'envoi d'un email, ici seulement utilisé pour les tests
        return true;
    }
}
