<?php

namespace App\Shared\Orm\Repository;

use App\Shared\Orm\Entity\LigneEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneEntity>
 *
 * @method LigneEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneEntity[]    findAll()
 * @method LigneEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneEntity::class);
    }

//    /**
//     * @return LigneEntity[] Returns an array of LigneEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneEntity
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
