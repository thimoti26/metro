<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Customer;

use App\Shared\Domain\Model\Entity;
use App\SimulationBoundedContext\Domain\Model\Gare\Gare;
use App\SimulationBoundedContext\Domain\Model\Simulation\Simulation;
use App\SimulationBoundedContext\Domain\Model\Train\Train;

class Customer implements Entity
{
    /** @var CustomerIdValueObject|null */
    protected ?CustomerIdValueObject $id;

    /** @var CustomerStateEnum */
    protected CustomerStateEnum $state;
    /** @var Gare */
    protected Gare $gareDepart;
    /** @var Gare */
    protected Gare $gareArrive;
    /** @var Gare|null */
    protected ?Gare $gare;
    /** @var Train|null */
    protected ?Train $train;
    /** @var Simulation */
    protected Simulation $simulation;

    /**
     * @param CustomerIdValueObject|null $id
     * @param CustomerStateEnum $state
     * @param Gare $gareDepart
     * @param Gare $gareArrive
     * @param Gare|null $gare
     * @param Train|null $train
     * @param Simulation $simulation
     */
    public function __construct(?CustomerIdValueObject $id, CustomerStateEnum $state, Gare $gareDepart, Gare $gareArrive, ?Gare $gare, ?Train $train, Simulation $simulation)
    {
        $this->id = $id;
        $this->state = $state;
        $this->gareDepart = $gareDepart;
        $this->gareArrive = $gareArrive;
        $this->gare = $gare;
        $this->train = $train;
        $this->simulation = $simulation;
    }

    /**
     * @return CustomerIdValueObject|null
     */
    public function getId(): ?CustomerIdValueObject
    {
        return $this->id;
    }

    /**
     * @return CustomerStateEnum
     */
    public function getState(): CustomerStateEnum
    {
        return $this->state;
    }

    /**
     * @return Gare
     */
    public function getGareDepart(): Gare
    {
        return $this->gareDepart;
    }

    /**
     * @return Gare
     */
    public function getGareArrive(): Gare
    {
        return $this->gareArrive;
    }

    /**
     * @return Gare|null
     */
    public function getGare(): ?Gare
    {
        return $this->gare;
    }

    /**
     * @return Train|null
     */
    public function getTrain(): ?Train
    {
        return $this->train;
    }

    /**
     * @return Simulation
     */
    public function getSimulation(): Simulation
    {
        return $this->simulation;
    }
}
