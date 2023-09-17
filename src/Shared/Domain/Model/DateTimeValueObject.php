<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use DateTimeInterface;

abstract class DateTimeValueObject implements ValueObject
{
    /** @var DateTimeInterface */
    protected DateTimeInterface $value;

    /**
     * @param DateTimeInterface $value
     */
    public function __construct(DateTimeInterface $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value->format('Y-m-d H:i:s');
    }

    /**
     * @return DateTimeInterface
     */
    public function getValue(): DateTimeInterface
    {
        return $this->value;
    }
}
