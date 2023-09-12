<?php

namespace App\Shared\Orm\Repository;

use App\Shared\Orm\Entity\GareEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GareEntity>
 *
 * @method GareEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GareEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GareEntity[]    findAll()
 * @method GareEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GareEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GareEntity::class);
    }

//    /**
//     * @return GareEntity[] Returns an array of GareEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GareEntity
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
