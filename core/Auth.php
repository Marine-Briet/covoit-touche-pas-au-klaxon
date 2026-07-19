<?php

namespace Core;

use Symfony\Component\HttpFoundation\Response;



/**
* Classe Auth fournit des méthodes statiques pour gérer l'authentification et l'autorisation des utilisateurs.
*
* @package Core
*/

class Auth
{
    /**
    * Vérifie si un utilisateur est connecté.
    *
    * @return bool
    */

    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    /**
    * Vérifie si l'utilisateur connecté est admin.
    *
    * @return bool
    */

    public static function isAdmin(): bool
    {
        return self::check() && $_SESSION['user']['est_admin'];
    }

    /**
    * Récupère les infos de l'utilisateur connecté (ou null)
    *
    * @return array<string, mixed>|null
    */

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
    * Vérifie si l'utilisateur est connecté, et le redirige vers /login s'il ne l'est pas.
    *
    * @param Response $response La réponse HTTP à modifier en cas de redirection
    * @return Response|null
    */

    public static function requireLogin(Response $response): ?Response
    {
        if (!self::check()) {
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/login');
            return $response;
        }

        return null;
    }

    /**
    * Vérifie si l'utilisateur est connecté ET qu'il a les droits admin.
    * Redirige vers /login si non connecté, ou vers / si connecté mais non admin.
    *
    * @param Response $response La réponse HTTP à modifier en cas de redirection
    * @return Response|null Une redirection si l'accès est refusé, null sinon
    */

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