<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use Core\Auth;
use Core\Flash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur de gestion des trajets côté administrateur.
 * L'administrateur a accès à la liste complète des trajets et peut
 * en supprimer, sans restriction d'auteur (contrairement à TrajetController).
 *
 * @package App\Controllers
 */
class AdminTrajetController
{
    /**
     * Affiche la liste complète de tous les trajets (GET /admin/trajets).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response La liste des trajets, ou une redirection si non autorisé
     */
    public function index(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAllWithDetails();

        ob_start();
        require __DIR__ . '/../../template/admin/trajets.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    /**
     * Supprime un trajet, quel qu'en soit l'auteur (POST /admin/trajet/delete/{id}).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @param int|string $id Identifiant du trajet à supprimer
     * @return Response Redirection vers la liste des trajets
     */
    public function delete(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $trajetModel = new TrajetModel();
        $trajetModel->delete((int) $id);

        Flash::set('delete', 'Le trajet a été supprimé.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/admin/trajets');
        return $response;
    }
}