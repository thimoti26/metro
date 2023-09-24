<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Repository;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Connexion>
 *
 * @method Connexion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connexion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connexion|null findOneById(int $id)
 * @method Connexion[]    findAll()
 * @method Connexion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnexionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connexion::class);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->getResult();
        //@TODO reset autoIncrement
    }

    /**
     * @param ConnexionArrayObject $connexionArrayObject
     * @return ConnexionArrayObject
     */
    public function persistCollection(ConnexionArrayObject $connexionArrayObject): ConnexionArrayObject
    {
        /** @var Connexion $connexion */
        foreach ($connexionArrayObject as $connexion) {
            $this->getEntityManager()->persist($connexion);
        }
        $this->getEntityManager()->flush();
        return $connexionArrayObject;
    }

    /**
     * @param Connexion $connexion
     * @return Connexion
     */
    public function persist(Connexion $connexion): Connexion
    {
        $this->getEntityManager()->persist($connexion);
        $this->getEntityManager()->flush();
        return $connexion;
    }
}
