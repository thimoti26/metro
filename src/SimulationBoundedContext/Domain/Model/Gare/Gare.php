<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Gare;

use App\Shared\Domain\Model\Entity;
use App\SimulationBoundedContext\Domain\Model\Ligne\Ligne;

class Gare implements Entity
{
    /** @var GareIdValueObject|null */
    protected ?GareIdValueObject $id;
    /** @var string */
    protected string $nom;
    /** @var Ligne */
    protected Ligne $ligne;

    /**
     * @param GareIdValueObject|null $id
     * @param string $nom
     * @param Ligne $ligne
     */
    public function __construct(?GareIdValueObject $id, string $nom, Ligne $ligne)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->ligne = $ligne;
    }

    /**
     * @return GareIdValueObject|null
     */
    public function getId(): ?GareIdValueObject
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return Ligne
     */
    public function getLigne(): Ligne
    {
        return $this->ligne;
    }
}
