<?php

namespace Core;

/**
* Classe Flash fournit des méthodes statiques pour gérer les messages flash.
*
* @package Core
*/


class Flash
{
    /**
    * Enregistre un message flash d'un certain type.
    *
    * @param string $type Le type du message flash
    * @param string $message Le message flash
    * @return void
    */

    public static function set(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    
    /**
    * Récupère un message flash d'un certain type et le supprime de la session.
    * @param string $type Le type du message flash à récupérer
    * @return string|null Le message flash ou null s'il n'existe pas
    */

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