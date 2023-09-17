<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\GareDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Infrastructure\Orm\Repository\GareRepository;
use App\Shared\Exception\InvalidCollectionParameterException;

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
        return $this->gareRepository->findOneById($gareIdValueObject->getValue());
    }

    /**
     * @return GareArrayObject
     * @throws InvalidCollectionParameterException
     */
    public function findAll(): GareArrayObject
    {
        return $this->gareRepository->findAll();
    }

    /**
     * @param string $name
     * @return Gare
     */
    public function findOneByNom(string $name): Gare
    {
        return $this->gareRepository->findOneByNom($name);
    }

    /**
     * @param Gare $gare
     * @return Gare
     */
    public function persist(Gare $gare): Gare
    {
        return $this->gareRepository->persist($gare);
    }
}
