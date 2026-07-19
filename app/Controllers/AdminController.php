<?php

namespace App\Controllers;

use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
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