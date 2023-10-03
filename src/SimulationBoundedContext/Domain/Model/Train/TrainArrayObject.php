<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Train;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;

/**
 * @extends ArrayObject<Train>
 */
class TrainArrayObject extends ArrayObject
{
    /** @inheritDoc */
    protected string $collectionClassType = Train::class;

    /**
     * @param Train $value
     * @return void
     * @throws InvalidCollectionParameterException
     */
    public function append(mixed $value): void
    {
        parent::append($value);
    }
}
