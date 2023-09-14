<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\GareDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Dao\GareFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Infrastructure\Repository\GareEntityDao;
use Symfony\Component\Serializer\SerializerInterface;

readonly class GareDatabaseDao implements GareDatabaseDaoInterface
{
    /**
     * @param GareEntityDao $gareEntityRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private GareEntityDao       $gareEntityRepository,
        private SerializerInterface $serializer
    )
    {
    }

    /**
     * @param GareArrayObject $gareArrayObject
     * @return GareArrayObject
     */
    public function persistCollection(GareArrayObject $gareArrayObject): GareArrayObject
    {
    }

    /**
     * @param GareIdValueObject $gareIdValueObject
     * @return Gare
     */
    public function findOneById(GareIdValueObject $gareIdValueObject): Gare
    {
        // TODO: Implement findOneById() method.
    }

    /**
     * @param Gare $gare
     * @return Gare
     */
    public function persist(Gare $gare): Gare
    {
        // TODO: Implement persist() method.
    }
}
