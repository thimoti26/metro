<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Connexion;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;

/**
 * @extends ArrayObject<Connexion>
 */
class ConnexionArrayObject extends ArrayObject
{
    /** @inheritDoc */
    protected string $collectionClassType = Connexion::class;

    /**
     * @param Connexion $value
     * @return void
     * @throws InvalidCollectionParameterException
     */
    public function append(mixed $value): void
    {
        parent::append($value);
    }
}
