<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\Shared\Infrastructure\Dao;

interface GareDatabaseDaoInterface extends Dao
{

    /**
     * @return void
     */
    public function reset(): void;
    /**
     * @param GareArrayObject $gareArrayObject
     * @return GareArrayObject
     */
    public function persistCollection(GareArrayObject $gareArrayObject): GareArrayObject;

    /**
     * @param GareIdValueObject $gareIdValueObject
     * @return Gare
     */
    public function findOneById(GareIdValueObject $gareIdValueObject): Gare;

    /**
     * @param Gare $gare
     * @return Gare
     */
    public function persist(Gare $gare): Gare;
}
