<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Model\File\Connexion;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject as BaseConnexion;
use App\Shared\Domain\Model\ArrayObject;

/**
 * @extends ArrayObject<Connexion>
 */
class ConnexionArrayObject extends BaseConnexion
{
    /** @var string */
    protected string $collectionClassType = Connexion::class;
}
