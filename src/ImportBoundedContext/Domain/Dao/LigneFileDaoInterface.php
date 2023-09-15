<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Infrastructure\Dao;

interface LigneFileDaoInterface extends Dao
{
    /**
     * @param FileNameValueObject $fileNameValueObject
     * @return LigneArrayObject
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): LigneArrayObject;
}
