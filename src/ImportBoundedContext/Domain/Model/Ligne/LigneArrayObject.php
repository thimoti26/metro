<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Ligne;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;

class LigneArrayObject extends ArrayObject
{
    /** @var string */
    protected string $collectionClassType = Ligne::class;

    /**
     * @param Ligne $value
     * @return void
     * @throws InvalidCollectionParameterException
     */
    public function append(mixed $value): void
    {
        parent::append($value); // TODO: Change the autogenerated stub
    }
}