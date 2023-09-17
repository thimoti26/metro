<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\LigneDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use App\ImportBoundedContext\Infrastructure\Orm\Repository\LigneRepository;
use App\Shared\Exception\InvalidCollectionParameterException;
use Symfony\Component\Serializer\SerializerInterface;

readonly class LigneDatabaseDao implements LigneDatabaseDaoInterface
{
    /**
     * @param LigneRepository $ligneRepository
     */
    public function __construct(
        private LigneRepository $ligneRepository
    )
    {
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->ligneRepository->reset();
    }

    /**
     * @param LigneArrayObject $ligneArrayObject
     * @return LigneArrayObject
     */
    public function persistCollection(LigneArrayObject $ligneArrayObject): LigneArrayObject
    {
        $this->ligneRepository->persistCollection($ligneArrayObject);
        return $ligneArrayObject;
    }

    /**
     * @param LigneIdValueObject $ligneIdValueObject
     * @return Ligne
     */
    public function findOneById(LigneIdValueObject $ligneIdValueObject): Ligne
    {
        return $this->ligneRepository->findOneById($ligneIdValueObject->getValue());
    }

    /**
     * @param string $name
     * @return Ligne
     */
    public function findOneByNom(string $name): Ligne
    {
        return $this->ligneRepository->findOneByNom($name);
    }

    /**
     * @return LigneArrayObject
     * @throws InvalidCollectionParameterException
     */
    public function findAll(): LigneArrayObject
    {
        return $this->ligneRepository->findAll();
    }

    /**
     * @param Ligne $ligne
     * @return Ligne
     */
    public function persist(Ligne $ligne): Ligne
    {
        // TODO: Implement persist() method.
        return $ligne;
    }
}
