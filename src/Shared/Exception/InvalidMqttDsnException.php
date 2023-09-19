<?php

declare(strict_types=1);

namespace App\Shared\Exception;

use RuntimeException;

class InvalidMqttDsnException extends RuntimeException
{
    /** @var string */
    const MESSAGE = 'The given MQTTT DSN "%s" is invalid.';
    /** @var int */
    const CODE = 0;

    /**
     * @param string $dsn
     */
    public function __construct(string $dsn)
    {
        parent::__construct(sprintf(self::MESSAGE, $dsn), self::CODE);
    }
}
