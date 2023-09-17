<?php

declare(strict_types=1);

namespace App\Shared\Exception;

use Exception;

class InvalidCollectionParameterException extends Exception
{
    /** @var string */
    const MESSAGE = 'Unable to apprend object of type %s, instance of %s required.';
    /** @var int */
    const CODE = 0;

    /**
     * @param string $type
     * @param string $collectionClassType
     */
    public function __construct(string $type, string $collectionClassType)
    {
        parent::__construct(sprintf(self::MESSAGE, $type, $collectionClassType), self::CODE);
    }
}
