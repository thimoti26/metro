<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use App\Shared\Infrastructure\Dao;

interface ConnexionDatabaseDaoInterface extends Dao
{

    /**
     * @param ConnexionArrayObject $connexionArrayObject
     * @return ConnexionArrayObject
     */
    public function persistCollection(ConnexionArrayObject $connexionArrayObject): ConnexionArrayObject;

    /**
     * @param ConnexionIdValueObject $connexionIdValueObject
     * @return Connexion
     */
    public function findOneById(ConnexionIdValueObject $connexionIdValueObject): Connexion;

    /**
     * @param Connexion $connexion
     * @return Connexion
     */
    public function persist(Connexion $connexion): Connexion;

    /**
     * @return void
     */
    public function reset(): void;
}
