<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Entity;

use \App\Shared\Orm\Entity\LigneEntity as BaseEntity;

class LigneEntity extends BaseEntity
{

    public function __construct(string $name, float $speed, float $spacing, string $color)
    {
        $this->name     = $name;
        $this->speed    = $speed;
        $this->spacing  = $spacing;
        $this->color    = $color;
    }
}
