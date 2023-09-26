<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Ligne;

use App\Shared\Domain\Model\Entity;

class Ligne implements Entity
{
    /** @var LigneIdValueObject|null */
    protected ?LigneIdValueObject $id;
    /** @var string */
    protected string $nom;
    /** @var float */
    protected float $vitesse;
    /** @var float */
    protected float $intervalle;
    /** @var string */
    protected string $couleur;

    /**
     * @param LigneIdValueObject|null $id
     * @param string $nom
     * @param float $vitesse
     * @param float $intervalle
     * @param string $couleur
     */
    public function __construct(?LigneIdValueObject $id, string $nom, float $vitesse, float $intervalle, string $couleur)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->vitesse = $vitesse;
        $this->intervalle = $intervalle;
        $this->couleur = $couleur;
    }

    /**
     * @return LigneIdValueObject|null
     */
    public function getId(): ?LigneIdValueObject
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
     * @return float
     */
    public function getVitesse(): float
    {
        return $this->vitesse;
    }

    /**
     * @return float
     */
    public function getIntervalle(): float
    {
        return $this->intervalle;
    }

    /**
     * @return string
     */
    public function getCouleur(): string
    {
        return $this->couleur;
    }
}
