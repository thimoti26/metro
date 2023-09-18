<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\ConnexionDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use App\ImportBoundedContext\Infrastructure\Orm\Repository\ConnexionRepository;

readonly class ConnexionDatabaseDao implements ConnexionDatabaseDaoInterface
{
    /**
     * @param ConnexionRepository $connexionRepository
     */
    public function __construct(
        private ConnexionRepository $connexionRepository
    )
    {
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->connexionRepository->reset();
    }

    /**
     * @param ConnexionArrayObject $connexionArrayObject
     * @return ConnexionArrayObject
     */
    public function persistCollection(ConnexionArrayObject $connexionArrayObject): ConnexionArrayObject
    {
        return $this->connexionRepository->persistCollection($connexionArrayObject);
    }

    /**
     * @param ConnexionIdValueObject $connexionIdValueObject
     * @return Connexion
     */
    public function findOneById(ConnexionIdValueObject $connexionIdValueObject): Connexion
    {
        return $this->connexionRepository->findOneById($connexionIdValueObject->getValue());
    }

    /**
     * @param Connexion $connexion
     * @return Connexion
     */
    public function persist(Connexion $connexion): Connexion
    {
        return $this->connexionRepository->persist($connexion);
    }
}
