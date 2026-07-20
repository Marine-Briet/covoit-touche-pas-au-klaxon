<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\TrajetModel;
use App\Models\AgenceModel;
use App\Models\UtilisateurModel;
use Core\Database;

class TrajetModelTest extends TestCase
{
    private TrajetModel $trajetModel;
    private int $idUtilisateur;
    private int $idAgenceDepart;
    private int $idAgenceArrivee;

    protected function setUp(): void
    {
        $this->trajetModel = new TrajetModel();
        $pdo = Database::getInstance()->getPdo();

        // On nettoie dans l'ordre à cause des clés étrangères (trajet dépend d'agence et utilisateur)
        $pdo->exec('DELETE FROM trajet');
        $pdo->exec('DELETE FROM agence');
        $pdo->exec('DELETE FROM utilisateur');

        // Création des données nécessaires (dépendances)
        $utilisateurModel = new UtilisateurModel();
        $utilisateurModel->insert([
            'nom' => 'Test',
            'prenom' => 'User',
            'telephone' => '0600000000',
            'email' => 'test@test.fr',
            'mot_de_passe' => password_hash('test1234', PASSWORD_DEFAULT),
            'est_admin' => 0,
        ]);
        $this->idUtilisateur = $utilisateurModel->findAll()[0]['id_utilisateur'];

        $agenceModel = new AgenceModel();
        $agenceModel->insert(['nom_ville' => 'Lille']);
        $agenceModel->insert(['nom_ville' => 'Paris']);
        $agences = $agenceModel->findAll();
        $this->idAgenceDepart = $agences[0]['id_agence'];
        $this->idAgenceArrivee = $agences[1]['id_agence'];
    }

    public function testInsert(): void
    {
        $this->trajetModel->insert([
            'date_depart' => '2026-08-01 08:00:00',
            'date_arrivee' => '2026-08-01 10:00:00',
            'nb_places_tot' => 3,
            'nb_places_dispo' => 3,
            'id_utilisateur' => $this->idUtilisateur,
            'id_agence_depart' => $this->idAgenceDepart,
            'id_agence_arrivee' => $this->idAgenceArrivee,
        ]);

        $resultat = $this->trajetModel->findAll();
        $this->assertCount(1, $resultat);
        $this->assertEquals(3, $resultat[0]['nb_places_dispo']);
    }

    public function testUpdate(): void
    {
        $this->trajetModel->insert([
            'date_depart' => '2026-08-01 08:00:00',
            'date_arrivee' => '2026-08-01 10:00:00',
            'nb_places_tot' => 3,
            'nb_places_dispo' => 3,
            'id_utilisateur' => $this->idUtilisateur,
            'id_agence_depart' => $this->idAgenceDepart,
            'id_agence_arrivee' => $this->idAgenceArrivee,
        ]);
        $trajet = $this->trajetModel->findAll()[0];

        $this->trajetModel->update($trajet['id_trajet'], ['nb_places_dispo' => 1]);

        $resultat = $this->trajetModel->findById($trajet['id_trajet']);
        $this->assertEquals(1, $resultat['nb_places_dispo']);
    }

    public function testDelete(): void
    {
        $this->trajetModel->insert([
            'date_depart' => '2026-08-01 08:00:00',
            'date_arrivee' => '2026-08-01 10:00:00',
            'nb_places_tot' => 3,
            'nb_places_dispo' => 3,
            'id_utilisateur' => $this->idUtilisateur,
            'id_agence_depart' => $this->idAgenceDepart,
            'id_agence_arrivee' => $this->idAgenceArrivee,
        ]);
        $trajet = $this->trajetModel->findAll()[0];

        $this->trajetModel->delete($trajet['id_trajet']);

        $resultat = $this->trajetModel->findById($trajet['id_trajet']);
        $this->assertNull($resultat);
    }
}