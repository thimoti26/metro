<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Gare;
use App\Shared\Domain\Model\Entity;

class Gare implements Entity
{
    /** @var GareIdValueObject|null */
    private ?GareIdValueObject $id;
    /** @var string */
    private string $nom;
    /** @var float */
    private float $longitude;
    /** @var float */
    private float $latitude;

    /**
     * @param GareIdValueObject|null $id
     * @param string $nom
     * @param float $longitude
     * @param float $latitude
     */
    public function __construct(?GareIdValueObject $id, string $nom, float $longitude, float $latitude)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
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
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }
}
