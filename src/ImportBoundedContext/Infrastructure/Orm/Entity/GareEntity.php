<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Entity;

use \App\Shared\Orm\Entity\GareEntity as BaseEntity;

class GareEntity extends BaseEntity
{

    public function __construct(string $name, float $longitude, float $latitude)
    {
        $this->name         = $name;
        $this->longitude    = $longitude;
        $this->latitude     = $latitude;
        parent::__construct();
    }
}
