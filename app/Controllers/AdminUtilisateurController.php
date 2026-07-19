<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur de gestion des utilisateurs côté administrateur.
 * Accès en lecture seule : les employés sont extraits du système RH
 * et ne peuvent être créés, modifiés ou supprimés depuis l'application.
 *
 * @package App\Controllers
 */
class AdminUtilisateurController
{
    /**
     * Affiche la liste de tous les utilisateurs (GET /admin/utilisateurs).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response La liste des utilisateurs, ou une redirection si non autorisé
     */
    public function index(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $utilisateurModel = new UtilisateurModel();
        $utilisateurs = $utilisateurModel->findAll();

        ob_start();
        require __DIR__ . '/../../template/admin/utilisateurs.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }
}