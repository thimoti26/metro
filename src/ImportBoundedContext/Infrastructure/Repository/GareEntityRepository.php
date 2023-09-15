<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Repository;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Domain\Repository\GareDaoInterface;
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

    public function persistCollection(GareArrayObject $gareArrayObject): GareArrayObject
    {
        // TODO: Implement persistCollection() method.
        return $gareArrayObject;
    }

    public function persist(Gare $gare): Gare
    {
        // TODO: Implement persist() method.
        return $gare;
    }
}
