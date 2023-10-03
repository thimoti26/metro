<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Simulation;

use App\Shared\Domain\Model\Entity;
use App\SimulationBoundedContext\Domain\Model\Customer\CustomerArrayObject;
use App\SimulationBoundedContext\Domain\Model\Train\TrainArrayObject;

class Simulation implements Entity
{
    /** @var SimulationIdValueObject|null */
    protected ?SimulationIdValueObject $id;
    /** @var TrainArrayObject */
    protected TrainArrayObject $trains;
    /** @var CustomerArrayObject */
    private CustomerArrayObject $customers;

    /**
     * @param SimulationIdValueObject|null $id
     * @param TrainArrayObject $trains
     * @param CustomerArrayObject $customers
     */
    public function __construct(?SimulationIdValueObject $id, TrainArrayObject $trains, CustomerArrayObject $customers)
    {
        $this->id = $id;
        $this->trains = $trains;
        $this->customers = $customers;
    }

    /**
     * @return SimulationIdValueObject|null
     */
    public function getId(): ?SimulationIdValueObject
    {
        return $this->id;
    }

    /**
     * @return TrainArrayObject
     */
    public function getTrains(): TrainArrayObject
    {
        return $this->trains;
    }

    /**
     * @return CustomerArrayObject
     */
    public function getCustomers(): CustomerArrayObject
    {
        return $this->customers;
    }

}
