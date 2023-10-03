<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Customer;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;

/**
 * @extends ArrayObject<Customer>
 */
class CustomerArrayObject extends ArrayObject
{
    /** @inheritDoc */
    protected string $collectionClassType = Customer::class;

    /**
     * @param Customer $value
     * @return void
     * @throws InvalidCollectionParameterException
     */
    public function append(mixed $value): void
    {
        parent::append($value);
    }
}
