<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Model\File\Connexion;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;

class ConnexionArrayObject extends ArrayObject
{
    /** @var string */
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
