<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Model\File\Connexion;

use App\Shared\Domain\Model\Entity;

class Connexion implements Entity
{
    /** @var ConnexionIdValueObject */
    protected ConnexionIdValueObject $id;
    /** @var string */
    protected string $ligne;
    /** @var string */
    protected string $depart;
    /** @var string */
    protected string $arrive;

    /**
     * @param ConnexionIdValueObject $id
     * @param string $ligne
     * @param string $depart
     * @param string $arrive
     */
    public function __construct(ConnexionIdValueObject $id, string $ligne, string $depart, string $arrive)
    {
        $this->id = $id;
        $this->ligne = $ligne;
        $this->depart = $depart;
        $this->arrive = $arrive;
    }

    public function getId(): ConnexionIdValueObject
    {
        return $this->id;
    }

    public function getLigne(): string
    {
        return $this->ligne;
    }

    public function getDepart(): string
    {
        return $this->depart;
    }

    public function getArrive(): string
    {
        return $this->arrive;
    }
}
