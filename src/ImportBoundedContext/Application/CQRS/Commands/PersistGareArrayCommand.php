<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\CQRS\Commands;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Application\CQRS\Command;

class PersistGareArrayCommand implements Command
{
    /**
     * @var GareArrayObject
     */
    private GareArrayObject $gares;

    /**
     * @param GareArrayObject $gares
     */
    public function __construct(GareArrayObject $gares)
    {
        $this->gares = $gares;
    }

    /**
     * @return GareArrayObject
     */
    public function getGares(): GareArrayObject
    {
        return $this->gares;
    }
}
