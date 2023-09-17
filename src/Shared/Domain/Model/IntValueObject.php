<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

abstract class IntValueObject implements ValueObject
{
    /** @var int */
    protected int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
