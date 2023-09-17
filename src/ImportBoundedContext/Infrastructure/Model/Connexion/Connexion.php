<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Model\Connexion;

class Connexion
{
    /** @var ConnexionIdValueObject|null */
    protected ?ConnexionIdValueObject $id;
    /** @var string */
    protected string $ligne;
    /** @var string */
    protected string $depart;
    /** @var string */
    protected string $arrive;

    /**
     * @param ConnexionIdValueObject|null $id
     * @param string $ligne
     * @param string $depart
     * @param string $arrive
     */
    public function __construct(?ConnexionIdValueObject $id, string $ligne, string $depart, string $arrive)
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
     * @return string
     */
    public function getLigne(): string
    {
        return $this->ligne;
    }

    /**
     * @return string
     */
    public function getDepart(): string
    {
        return $this->depart;
    }

    /**
     * @return string
     */
    public function getArrive(): string
    {
        return $this->arrive;
    }
}
