<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\CQRS\Queries;

use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\Shared\Application\CQRS\Query;

final class FindLigneByFileNameQuery implements Query
{
    /**
     * @var FileNameValueObject
     */
    private FileNameValueObject $filename;

    /**
     * @param FileNameValueObject $filename
     */
    public function __construct(FileNameValueObject $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return FileNameValueObject
     */
    public function getFilename(): FileNameValueObject
    {
        return $this->filename;
    }

}
