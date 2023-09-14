<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Service;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Infrastructure\DAO\GareDatabaseDao;

class ImportService
{
    public function __construct(private GareDatabaseDao $gareDao)
    {
    }

    public function importGares(GareArrayObject $gares): GareArrayObject
    {
        return $this->gareDao->persistCollection($gares);
    }

    public function importLignes(LigneArrayObject $lignes): LigneArrayObject
    {
    }

    public function importConnexion(ConnexionArrayObject $connexions): ConnexionArrayObject
    {
    }
}
