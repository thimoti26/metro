<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Exception;

use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use Exception;

class FileNotFoundException extends Exception
{
    /** @var string */
    const MESSAGE = 'File not found %s.';
    /** @var int */
    const CODE = 0;

    /**
     * @param FileNameValueObject $fileNameValueObject
     */
    public function __construct(FileNameValueObject $fileNameValueObject)
    {
        parent::__construct(sprintf(self::MESSAGE, $fileNameValueObject->getValue()), self::CODE);
    }
}
