<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use App\Models\AgenceModel;
use Core\Flash;
use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

/**
 * Contrôleur de gestion des trajets (côté utilisateur connecté).
 * Gère la création, la modification et la suppression des trajets,
 * avec vérification systématique que l'utilisateur est bien l'auteur.
 *
 * @package App\Controllers
 */
class TrajetController
{
    /**
     * Affiche le formulaire de création d'un trajet (GET /trajet/create).
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @return Response Le formulaire de création, ou une redirection si non connecté
     */
    public function showCreateForm(Request $request, Response $response)
    {
        $redirect = Auth::requireLogin($response);
        if ($redirect) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        ob_start();
        require __DIR__ . '/../../template/trajet_create.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    /**
     * Traite la création d'un trajet (POST /trajet/create).
     * Vérifie la cohérence des données (agences différentes, date d'arrivée
     * postérieure à la date de départ) avant l'insertion en base.
     *
     * @param Request $request La requête HTTP contenant les données du formulaire
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @return Response Redirection vers l'accueil (succès) ou le formulaire (erreur)
     */
    public function create(Request $request, Response $response)
    {
        $redirect = Auth::requireLogin($response);
        if ($redirect) {
            return $redirect;
        }

        $idAgenceDepart = (int) $request->request->get('id_agence_depart');
        $idAgenceArrivee = (int) $request->request->get('id_agence_arrivee');
        $dateDepart = $request->request->get('date_depart');
        $dateArrivee = $request->request->get('date_arrivee');
        $nbPlacesTot = (int) $request->request->get('nb_places_tot');

        if ($idAgenceDepart === $idAgenceArrivee) {
            Flash::set('error', 'L\'agence de départ et l\'agence d\'arrivée doivent être différentes.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/trajet/create');
            return $response;
        }

        $objDateDepart = new DateTime($dateDepart);
        $objDateArrivee = new DateTime($dateArrivee);

        if ($objDateArrivee <= $objDateDepart) {
            Flash::set('error', 'La date d\'arrivée doit être postérieure à la date de départ.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/trajet/create');
            return $response;
        }

        $trajetModel = new TrajetModel();
        $trajetModel->insert([
            'id_agence_depart'  => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee,
            'date_depart'       => $dateDepart,
            'date_arrivee'      => $dateArrivee,
            'nb_places_tot'     => $nbPlacesTot,
            'nb_places_dispo'   => $nbPlacesTot,
            'id_utilisateur'    => $_SESSION['user']['id_utilisateur'],
        ]);

        Flash::set('success', 'Le trajet a été créé.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }

    /**
     * Affiche le formulaire de modification d'un trajet (GET /trajet/edit/{id}).
     * Vérifie que l'utilisateur connecté est bien l'auteur du trajet.
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter
     * @param int|string $id Identifiant du trajet à modifier
     * @return Response Le formulaire de modification, ou une redirection si non autorisé
     */
    public function showEditForm(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireLogin($response);
        if ($redirect) {
            return $redirect;
        }

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findByIdWithDetails((int) $id);

        if (!$trajet || $trajet['id_utilisateur'] !== $_SESSION['user']['id_utilisateur']) {
            Flash::set('error', 'Vous n\'êtes pas autorisé à modifier ce trajet.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/');
            return $response;
        }

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        ob_start();
        require __DIR__ . '/../../template/trajet_edit.php';
        $content = ob_get_clean();

        $response->setContent($content);
        return $response;
    }

    /**
     * Traite la modification d'un trajet (POST /trajet/edit/{id}).
     * Vérifie l'auteur, la cohérence des données, et recalcule le nombre
     * de places disponibles en conservant les places déjà réservées.
     *
     * @param Request $request La requête HTTP contenant les données du formulaire
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @param int|string $id Identifiant du trajet à modifier
     * @return Response Redirection vers l'accueil (succès) ou le formulaire (erreur)
     */
    public function edit(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireLogin($response);
        if ($redirect) {
            return $redirect;
        }

        $id = (int) $id;
        $trajetModel = new TrajetModel();
        $trajetExistant = $trajetModel->findByIdWithDetails($id);

        if (!$trajetExistant || $trajetExistant['id_utilisateur'] !== $_SESSION['user']['id_utilisateur']) {
            Flash::set('error', 'Vous n\'êtes pas autorisé à modifier ce trajet.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/');
            return $response;
        }

        $idAgenceDepart = (int) $request->request->get('id_agence_depart');
        $idAgenceArrivee = (int) $request->request->get('id_agence_arrivee');
        $dateDepart = $request->request->get('date_depart');
        $dateArrivee = $request->request->get('date_arrivee');
        $nbPlacesTot = (int) $request->request->get('nb_places_tot');

        if ($idAgenceDepart === $idAgenceArrivee) {
            Flash::set('error', 'L\'agence de départ et l\'agence d\'arrivée doivent être différentes.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/trajet/edit/' . $id);
            return $response;
        }

        $objDateDepart = new DateTime($dateDepart);
        $objDateArrivee = new DateTime($dateArrivee);

        if ($objDateArrivee <= $objDateDepart) {
            Flash::set('error', 'La date d\'arrivée doit être postérieure à la date de départ.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/trajet/edit/' . $id);
            return $response;
        }

        // On garde le même nombre de places déjà réservées : places prises = total actuel - dispo actuel
        $placesPrises = $trajetExistant['nb_places_tot'] - $trajetExistant['nb_places_dispo'];
        $nouvellesPlacesDispo = $nbPlacesTot - $placesPrises;

        $trajetModel->update($id, [
            'id_agence_depart'  => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee,
            'date_depart'       => $dateDepart,
            'date_arrivee'      => $dateArrivee,
            'nb_places_tot'     => $nbPlacesTot,
            'nb_places_dispo'   => $nouvellesPlacesDispo,
        ]);

        Flash::set('success', 'Le trajet a été modifié.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }

    /**
     * Supprime un trajet (POST /trajet/delete/{id}).
     * Vérifie que l'utilisateur connecté est bien l'auteur du trajet.
     *
     * @param Request $request La requête HTTP entrante
     * @param Response $response La réponse HTTP à compléter (redirection)
     * @param int|string $id Identifiant du trajet à supprimer
     * @return Response Redirection vers l'accueil, avec message flash de succès ou d'erreur
     */
    public function delete(Request $request, Response $response, $id)
    {
        $redirect = Auth::requireLogin($response);
        if ($redirect) {
            return $redirect;
        }

        $id = (int) $id;
        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findByIdWithDetails($id);

        if (!$trajet || $trajet['id_utilisateur'] !== $_SESSION['user']['id_utilisateur']) {
            Flash::set('error', 'Vous n\'êtes pas autorisé à supprimer ce trajet.');
            $response->setStatusCode(302);
            $response->headers->set('Location', BASE_URL . '/');
            return $response;
        }        

        $trajetModel->delete($id);

        Flash::set('success', 'Le trajet a été supprimé.');
        $response->setStatusCode(302);
        $response->headers->set('Location', BASE_URL . '/');
        return $response;
    }
}