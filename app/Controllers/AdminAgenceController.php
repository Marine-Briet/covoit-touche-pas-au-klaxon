<?php

namespace App\Controllers;

use App\Models\AgenceModel;
use Core\Auth;
use Core\Flash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAgenceController
{
    public function index(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        ob_start();
        require __DIR__ . '/../../template/admin/agences.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    public function showCreateForm(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $agence = null; // pas d'agence existante = mode création

        ob_start();
        require __DIR__ . '/../../template/admin/agence_form.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    public function create(Request $request, Response $response)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $nomVille = $request->request->get('nom_ville');

        $agenceModel = new AgenceModel();
        $agenceModel->insert(['nom_ville' => $nomVille]);

        Flash::set('success', 'L\'agence a été créée.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/admin/agences');
        return $response;
    }

    public function showEditForm(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agence = $agenceModel->findById((int) $id);

        if (!$agence) {
            Flash::set('error', 'Agence introuvable.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/admin/agences');
            return $response;
        }

        ob_start();
        require __DIR__ . '/../../template/admin/agence_form.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    public function edit(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $nomVille = $request->request->get('nom_ville');

        $agenceModel = new AgenceModel();
        $agenceModel->update((int) $id, ['nom_ville' => $nomVille]);

        Flash::set('success', 'L\'agence a été modifiée.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/admin/agences');
        return $response;
    }

    public function delete(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireAdmin($response);
        if ($redirect) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agenceModel->delete((int) $id);

        Flash::set('success', 'L\'agence a été supprimée.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/admin/agences');
        return $response;
    }
}