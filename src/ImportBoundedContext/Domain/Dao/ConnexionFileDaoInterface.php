<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\Shared\Infrastructure\Dao;

interface ConnexionFileDaoInterface extends Dao
{
    /**
     * @param FileNameValueObject $fileNameValueObject
     * @return ConnexionArrayObject
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): ConnexionArrayObject;
}
