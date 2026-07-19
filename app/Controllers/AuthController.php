<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Flash;

/**
 * Contrôleur gérant l'authentification des utilisateurs (connexion / déconnexion).
 *
 * @package App\Controllers
 */
class AuthController
{
    /**
     * Affiche le formulaire de connexion (GET /login).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response La réponse contenant le formulaire de connexion
     */
    public function showLoginForm(Request $request, Response $response)
    {
        ob_start();
        require __DIR__ . '/../../template/login.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    /**
     * Traite la soumission du formulaire de connexion (POST /login).
     * Vérifie l'email et le mot de passe, ouvre la session si valide,
     * sinon redirige vers /login avec un message d'erreur.
     *
     * @param Request $request La requête HTTP contenant email et mot de passe
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @return Response La redirection vers l'accueil (succès) ou /login (échec)
     */
    public function login(Request $request, Response $response)
    {
        $email = $request->request->get('email');
        $motDePasse = $request->request->get('mot_de_passe');

        $utilisateurModel = new UtilisateurModel();
        $utilisateur = $utilisateurModel->findByEmail($email);

        // Vérification de l'utilisateur et du mot de passe correspondant
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

    /**
     * Déconnecte l'utilisateur (GET /logout) en détruisant sa session.
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @return Response La redirection vers la page d'accueil
     */
    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['user']);

        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }
}