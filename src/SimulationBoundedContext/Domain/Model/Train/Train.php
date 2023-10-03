<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Train;

use App\Shared\Domain\Model\Entity;
use App\SimulationBoundedContext\Domain\Model\Gare\Gare;
use App\SimulationBoundedContext\Domain\Model\Ligne\Ligne;
use App\SimulationBoundedContext\Domain\Model\Simulation\Simulation;

class Train implements Entity
{
    /** @var TrainIdValueObject|null */
    protected ?TrainIdValueObject $id;
    /** @var Ligne */
    protected Ligne $ligne;
    /** @var Gare|null */
    protected ?Gare $gare;
    /** @var Simulation */
    protected Simulation $simulation;

    /**
     * @param TrainIdValueObject|null $id
     * @param Ligne $ligne
     * @param Gare|null $gare
     * @param Simulation $simulation
     */
    public function __construct(?TrainIdValueObject $id, Ligne $ligne, ?Gare $gare, Simulation $simulation)
    {
        $this->id = $id;
        $this->ligne = $ligne;
        $this->gare = $gare;
        $this->simulation = $simulation;
    }

    /**
     * @return TrainIdValueObject|null
     */
    public function getId(): ?TrainIdValueObject
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
     * @return Gare|null
     */
    public function getGare(): ?Gare
    {
        return $this->gare;
    }

    /**
     * @return Simulation
     */
    public function getSimulation(): Simulation
    {
        return $this->simulation;
    }
}
