<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Dao;

use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Infrastructure\Dao;

interface GareFileDaoInterface extends Dao
{
    /**
     * @param FileNameValueObject $fileNameValueObject
     * @return GareArrayObject
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): GareArrayObject;
}
