<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\ConnexionDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use App\ImportBoundedContext\Infrastructure\Orm\Repository\ConnexionRepository;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ConnexionDatabaseDao implements ConnexionDatabaseDaoInterface
{
    /**
     * @param ConnexionRepository $connexionEntityRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private ConnexionRepository $connexionEntityRepository,
        private SerializerInterface $serializer
    )
    {
    }

    /**
     * @param ConnexionArrayObject $connexionArrayObject
     * @return ConnexionArrayObject
     */
    public function persistCollection(ConnexionArrayObject $connexionArrayObject): ConnexionArrayObject
    {
        // TODO: Implement persistCollection() method.
        return $connexionArrayObject;
    }

    /**
     * @param ConnexionIdValueObject $connexionIdValueObject
     * @return Connexion
     */
    public function findOneById(ConnexionIdValueObject $connexionIdValueObject): Connexion
    {
        // TODO: Implement findOneById() method.
        return new Connexion($connexionIdValueObject, new LigneIdValueObject("1"), new GareIdValueObject("a"), new GareIdValueObject("a"));
    }

    /**
     * @param Connexion $connexion
     * @return Connexion
     */
    public function persist(Connexion $connexion): Connexion
    {
        // TODO: Implement persist() method.
        return $connexion;
    }
}
