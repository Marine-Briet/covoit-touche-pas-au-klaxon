<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Flash;


class AuthController
{
    
    // Affiche le formulaire de connexion (GET /login)
    
    public function showLoginForm(Request $request, Response $response)
    {
        ob_start();
        require __DIR__ . '/../../template/login.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    
    // Traite la soumission du formulaire (POST /login)

    public function login(Request $request, Response $response)
    {
        $email = $request->request->get('email');
        $motDePasse = $request->request->get('mot_de_passe');

        $utilisateurModel = new UtilisateurModel();
        $utilisateur = $utilisateurModel->findByEmail($email);

        // Vérification l'utilisateur et le mot de passe correspondant
        if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id_utilisateur' => $utilisateur['id_utilisateur'],
                'nom'            => $utilisateur['nom'],
                'prenom'         => $utilisateur['prenom'],
                'email'          => $utilisateur['email'],
                'telephone'      => $utilisateur['telephone'],
                'est_admin'      => (bool) $utilisateur['est_admin'],
            ];

            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/');
            return $response;
        }

        // Échec : un message d'erreur
        Flash::set('error', 'Email ou mot de passe incorrect.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/login');
        return $response;
    }

    
    // Déconnexion (GET /logout)
    
    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['user']);

        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }
}