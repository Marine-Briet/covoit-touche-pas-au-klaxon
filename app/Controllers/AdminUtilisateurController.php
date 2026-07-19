<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUtilisateurController
{
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