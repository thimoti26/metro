<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Entity;

use \App\Shared\Orm\Entity\ConnexionEntity as BaseEntity;

class ConnexionEntity extends BaseEntity
{

    public function __construct(LigneEntity $ligne, GareEntity $depart, GareEntity $arrive)
    {
        $this->ligne    = $ligne;
        $this->depart   = $depart;
        $this->arrive   = $arrive;
    }
}
