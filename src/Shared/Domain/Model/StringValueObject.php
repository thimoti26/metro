<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

abstract class StringValueObject implements ValueObject
{
    /** @var string */
    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
