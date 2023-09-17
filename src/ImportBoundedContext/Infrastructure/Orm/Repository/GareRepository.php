<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Repository;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gare>
 *
 * @method Gare|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gare|null findOneBy(array $criteria, array $orderBy = null)
 * @method GareArrayObject findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GareRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gare::class);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->createQueryBuilder('g')
            ->delete()
            ->getQuery()
            ->getResult();
        //@TODO reset autoIncrement
    }

    /**
     * @param GareArrayObject $gareArrayObject
     * @return GareArrayObject
     */
    public function persistCollection(GareArrayObject $gareArrayObject): GareArrayObject
    {
        /** @var Gare $gare */
        foreach ($gareArrayObject as &$gare) {
            $this->getEntityManager()->persist($gare);
        }
        $this->getEntityManager()->flush();
        return $gareArrayObject;
    }

    /**
     * @param Gare $gare
     * @return Gare
     */
    public function persist(Gare $gare): Gare
    {
        $this->getEntityManager()->persist($gare);
        $this->getEntityManager()->flush();
        return $gare;
    }

    /**
     * @return GareArrayObject
     * @throws InvalidCollectionParameterException
     */
    public function findAll(): GareArrayObject
    {
        $gares = parent::findAll();
        $gareArrayObject = new GareArrayObject();
        foreach ($gares as $gare) {
            $gareArrayObject->append($gare);
        }
        return $gareArrayObject;
    }
}
