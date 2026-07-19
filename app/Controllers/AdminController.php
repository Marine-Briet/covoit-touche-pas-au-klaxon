<?php

namespace App\Controllers;

use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur du tableau de bord administrateur (page d'accueil de l'espace admin).
 *
 * @package App\Controllers
 */
class AdminController
{
    /**
     * Affiche le tableau de bord administrateur (GET /admin).
     * Accès réservé aux administrateurs.
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response Le tableau de bord, ou une redirection si non autorisé
     */
    public function index(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        ob_start();
        require __DIR__ . '/../../template/admin/dashboard.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }
}