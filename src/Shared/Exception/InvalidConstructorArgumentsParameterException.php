<?php

declare(strict_types=1);

namespace App\Shared\Exception;

use RuntimeException as RuntimeExceptionAlias;

class InvalidConstructorArgumentsParameterException extends RuntimeExceptionAlias
{
    /** @var string */
    const MESSAGE   = 'Cannot create an instance of "%s" from serialized data because its constructor requires the following parameters to be present : "%s".';
    /** @var int */
    const CODE      = 0;

    /**
     * @param string $objectName
     * @param array $argumentsConstructor
     * @param array $argumentsProvided
     */
    public function __construct(string $objectName, array $argumentsMissing)
    {
        parent::__construct(sprintf(self::MESSAGE, $objectName, implode(',', $argumentsMissing)), self::CODE);
    }
}
