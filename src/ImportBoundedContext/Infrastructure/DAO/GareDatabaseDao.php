<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\GareDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Infrastructure\Orm\Repository\GareRepository;

readonly class GareDatabaseDao implements GareDatabaseDaoInterface
{
    /**
     * @param GareRepository $gareRepository
     */
    public function __construct(
        private GareRepository $gareRepository
    )
    {
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->gareRepository->reset();
    }

    /**
     * @param GareArrayObject $gareArrayObject
     * @return GareArrayObject
     */
    public function persistCollection(GareArrayObject $gareArrayObject): GareArrayObject
    {
        $this->gareRepository->persistCollection($gareArrayObject);
        return $gareArrayObject;
    }

    /**
     * @param GareIdValueObject $gareIdValueObject
     * @return Gare
     */
    public function findOneById(GareIdValueObject $gareIdValueObject): Gare
    {
        // TODO: Implement findOneById() method.
        return new Gare($gareIdValueObject, 'nom', 2, 2);
    }

    /**
     * @param Gare $gare
     * @return Gare
     */
    public function persist(Gare $gare): Gare
    {
        // TODO: Implement persist() method.
        return $gare;
    }
}
