<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use App\Models\AgenceModel;
use Core\Flash;
use Core\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;


// Contrôleur de gestion des trajets (côté utilisateur)

class TrajetController
{
    
     // Affiche le formulaire de création (GET /trajet/create)
     
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

    
    // Traite la création (POST /trajet/create)


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
     * Affiche le formulaire de modification (GET /trajet/edit/{id})
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
     * Traite la modification (POST /trajet/edit/{id})
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