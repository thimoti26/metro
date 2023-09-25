<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Model\File\Connexion;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion as BaseConnexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;

class Connexion extends BaseConnexion
{
    /** @var \App\ImportBoundedContext\Infrastructure\Model\File\Connexion\ConnexionIdValueObject|null */
    protected ?ConnexionIdValueObject $id;
}
