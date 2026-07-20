<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\AgenceModel;
use Core\Database;

class AgenceModelTest extends TestCase
{
    private AgenceModel $agenceModel;

    protected function setUp(): void
    {
        $this->agenceModel = new AgenceModel();

        // On vide la table avant chaque test pour repartir sur une base propre
        Database::getInstance()->getPdo()->exec('DELETE FROM agence');
    }

    public function testInsert(): void
    {
    
        $this->agenceModel->insert(['nom_ville' => 'Lille']);
        $resultat = $this->agenceModel->findAll();
        $this->assertCount(1, $resultat);
        $this->assertEquals('Lille', $resultat[0]['nom_ville']); 
    }

    public function testUpdate(): void
    {
        $this->agenceModel->insert(['nom_ville' => 'Lille']);
        $agence = $this->agenceModel->findAll()[0];

        $this->agenceModel->update($agence['id_agence'], ['nom_ville' => 'Paris']);
        $resultat = $this->agenceModel->findById($agence['id_agence']);
        $this->assertEquals('Paris', $resultat['nom_ville']);
    }

    public function testDelete(): void
    {
        $this->agenceModel->insert(['nom_ville' => 'Lille']);
        $agence = $this->agenceModel->findAll()[0];

        $this->agenceModel->delete($agence['id_agence']);
        $resultat = $this->agenceModel->findById($agence['id_agence']);
        $this->assertNull($resultat);
    }
}