<?php

namespace App\Controllers;

use App\Models\AgenceModel;
use Core\Auth;
use Core\Flash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur de gestion des agences (villes) côté administrateur.
 * Seul l'administrateur peut créer, modifier ou supprimer une agence.
 *
 * @package App\Controllers
 */
class AdminAgenceController
{
    /**
     * Affiche la liste de toutes les agences (GET /admin/agences).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response La liste des agences, ou une redirection si non autorisé
     */
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

    /**
     * Affiche le formulaire de création d'une agence (GET /admin/agence/create).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response Le formulaire (mode création), ou une redirection si non autorisé
     */
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

    /**
     * Traite la création d'une agence (POST /admin/agence/create).
     *
     * @param Request $request La requête HTTP contenant le nom de la ville
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @return Response Redirection vers la liste des agences
     */
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

    /**
     * Affiche le formulaire de modification d'une agence (GET /admin/agence/edit/{id}).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @param int|string $id Identifiant de l'agence à modifier
     * @return Response Le formulaire (mode édition), ou une redirection si non trouvée/non autorisé
     */
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

    /**
     * Traite la modification d'une agence (POST /admin/agence/edit/{id}).
     *
     * @param Request $request La requête HTTP contenant le nouveau nom de la ville
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @param int|string $id Identifiant de l'agence à modifier
     * @return Response Redirection vers la liste des agences
     */
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

    /**
     * Supprime une agence (POST /admin/agence/delete/{id}).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @param int|string $id Identifiant de l'agence à supprimer
     * @return Response Redirection vers la liste des agences
     */
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