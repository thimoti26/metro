<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\CQRS\Commands;

use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Application\CQRS\Command;

class PersistLigneArrayCommand implements Command
{
    /**
     * @var LigneArrayObject
     */
    private LigneArrayObject $lignes;

    /**
     * @param LigneArrayObject $lignes
     */
    public function __construct(LigneArrayObject $lignes)
    {
        $this->lignes = $lignes;
    }

    /**
     * @return LigneArrayObject
     */
    public function getLignes(): LigneArrayObject
    {
        return $this->lignes;
    }
}
