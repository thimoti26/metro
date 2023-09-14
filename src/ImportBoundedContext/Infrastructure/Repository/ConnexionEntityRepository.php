<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Repository;

use App\Shared\Orm\Entity\ConnexionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnexionEntity>
 *
 * @method ConnexionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnexionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnexionEntity[]    findAll()
 * @method ConnexionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnexionEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnexionEntity::class);
    }

//    /**
//     * @return Connexion[] Returns an array of Connexion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Connexion
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
