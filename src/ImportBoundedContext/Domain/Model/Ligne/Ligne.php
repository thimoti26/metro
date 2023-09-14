<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Ligne;

class Ligne
{
    /** @var LigneIdValueObject|null */
    private ?LigneIdValueObject $id;
    /** @var string */
    private string $nom;
    /** @var float */
    private float $vitesse;
    /** @var float */
    private float $intervalle;
    /** @var string */
    private string $couleur;

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
