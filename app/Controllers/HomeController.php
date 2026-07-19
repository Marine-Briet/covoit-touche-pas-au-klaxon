<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur de la page d'accueil, accessible à tous (visiteurs et connectés).
 * Affiche la liste des trajets disponibles, triés par date de départ croissante.
 *
 * @package App\Controllers
 */
class HomeController
{
    /**
     * Affiche la page d'accueil avec la liste des trajets disponibles (GET /).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response La page d'accueil contenant la liste des trajets
     */
    public function index(Request $request, Response $response)
    {
        // 1. On récupère les données depuis le Modèle
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAllAvailable();

        // 2. On "capture" le HTML généré par la vue au lieu de le laisser s'afficher directement
        ob_start();
        require __DIR__ . '/../../template/home.php';
        $content = ob_get_clean();

        // 3. On injecte ce HTML capturé dans la réponse HTTP
        $response->setContent($content);

        return $response;
    }
}