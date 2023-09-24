<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Connexion;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\Shared\Domain\Model\Entity;

/**
 * @implements Entity<Connexion>
 */
class Connexion implements Entity
{
    /** @var ConnexionIdValueObject|null */
    protected ?ConnexionIdValueObject $id;
    /** @var Ligne */
    protected Ligne $ligne;
    /** @var Gare */
    protected Gare $depart;
    /** @var Gare */
    protected Gare $arrive;

    /**
     * @param ConnexionIdValueObject|null $id
     * @param Ligne $ligne
     * @param Gare $depart
     * @param Gare $arrive
     */
    public function __construct(?ConnexionIdValueObject $id, Ligne $ligne, Gare $depart, Gare $arrive)
    {
        $this->id = $id;
        $this->ligne = $ligne;
        $this->depart = $depart;
        $this->arrive = $arrive;
    }

    /**
     * @return ConnexionIdValueObject|null
     */
    public function getId(): ?ConnexionIdValueObject
    {
        return $this->id;
    }

    /**
     * @return Ligne
     */
    public function getLigne(): Ligne
    {
        return $this->ligne;
    }

    /**
     * @return Gare
     */
    public function getDepart(): Gare
    {
        return $this->depart;
    }

    /**
     * @return Gare
     */
    public function getArrive(): Gare
    {
        return $this->arrive;
    }
}
