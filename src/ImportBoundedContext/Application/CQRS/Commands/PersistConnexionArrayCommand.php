<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\CQRS\Commands;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\Shared\Application\CQRS\Command;

class PersistConnexionArrayCommand implements Command
{
    /**
     * @var ConnexionArrayObject
     */
    private ConnexionArrayObject $connexions;

    /**
     * @param ConnexionArrayObject $connexions
     */
    public function __construct(ConnexionArrayObject $connexions)
    {
        $this->connexions = $connexions;
    }

    /**
     * @return ConnexionArrayObject
     */
    public function getConnexions(): ConnexionArrayObject
    {
        return $this->connexions;
    }
}
