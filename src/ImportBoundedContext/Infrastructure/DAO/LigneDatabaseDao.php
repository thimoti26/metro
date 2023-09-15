<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\LigneDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use App\ImportBoundedContext\Infrastructure\Repository\LigneEntityRepository;
use Symfony\Component\Serializer\SerializerInterface;

readonly class LigneDatabaseDao implements LigneDatabaseDaoInterface
{
    /**
     * @param LigneEntityRepository $ligneEntityRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private LigneEntityRepository $ligneEntityRepository,
        private SerializerInterface  $serializer
    )
    {
    }

    /**
     * @param LigneArrayObject $ligneArrayObject
     * @return LigneArrayObject
     */
    public function persistCollection(LigneArrayObject $ligneArrayObject): LigneArrayObject
    {
        // TODO: Implement persistCollection() method.
        return $ligneArrayObject;
    }

    /**
     * @param LigneIdValueObject $ligneIdValueObject
     * @return Ligne
     */
    public function findOneById(LigneIdValueObject $ligneIdValueObject): Ligne
    {
        // TODO: Implement findOneById() method.
        return new Ligne($ligneIdValueObject, 'nom', 2, 2, 'bleu');
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
