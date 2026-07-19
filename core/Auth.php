<?php

namespace Core;

use Symfony\Component\HttpFoundation\Response;


//Utilitaires liés à l'authentification / autorisation

class Auth
{

    // Vérifie si un utilisateur est connecté

    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    
    // Vérifie si l'utilisateur connecté est admin
    
    public static function isAdmin(): bool
    {
        return self::check() && $_SESSION['user']['est_admin'];
    }

    
    // Récupère les infos de l'utilisateur connecté (ou null)
    
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    
    // Si personne n'est connecté, redirige vers /login et retourne une Response. Sinon, retourne null (pas de redirection nécessaire).
     
    public static function requireLogin(Response $response): ?Response
    {
        if (!self::check()) {
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/login');
            return $response;
        }

        return null;
    }

    public static function requireAdmin(Response $response): ?Response
    {
    if (!self::check()) {
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/login');
        return $response;
    }

    if (!self::isAdmin()) {
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }

    return null;
    }
}