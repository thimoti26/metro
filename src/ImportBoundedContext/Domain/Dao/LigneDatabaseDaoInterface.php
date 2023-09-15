<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use App\Shared\Infrastructure\Dao;

interface LigneDatabaseDaoInterface extends Dao
{

    /**
     * @param LigneArrayObject $ligneArrayObject
     * @return LigneArrayObject
     */
    public function persistCollection(LigneArrayObject $ligneArrayObject): LigneArrayObject;

    /**
     * @param LigneIdValueObject $ligneIdValueObject
     * @return Ligne
     */
    public function findOneById(LigneIdValueObject $ligneIdValueObject): Ligne;

    /**
     * @param Ligne $ligne
     * @return Ligne
     */
    public function persist(Ligne $ligne): Ligne;
}
