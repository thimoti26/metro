<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Repository;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\Shared\Infrastructure\Repository;

interface GareRepositoryInterface extends Repository
{
    /**
     * @param GareIdValueObject $valueObject
     * @return Gare
     */
    public function findOneById(GareIdValueObject $valueObject): Gare;

    /**
     * @param GareArrayObject $arrayObject
     * @return GareArrayObject
     */
    public function persistCollection(GareArrayObject $arrayObject): GareArrayObject;

    /**
     * @param Gare $entity
     * @return Gare
     */
    public function persist(Gare $entity): Gare;
}
