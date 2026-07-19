<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use Core\Auth;
use Core\Flash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTrajetController
{
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

    public function delete(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $trajetModel = new TrajetModel();
        $trajetModel->delete((int) $id);

        Flash::set('success', 'Le trajet a été supprimé.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/admin/trajets');
        return $response;
    }
}