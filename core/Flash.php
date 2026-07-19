<?php

namespace Core;

// Gestion centralisée des messages flash (succès, erreur, etc.)

class Flash
{

    // Enregistre un message flash d'un certain type
    
    public static function set(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    
    // Récupère un message flash (et le supprime immédiatement après lecture)
    
    public static function get(string $type): ?string
    {
        if (!empty($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }

        return null;
    }
}