<?php
declare(strict_types=1);

namespace App\SimulationBoundedContext\Domain\Model\Customer;

enum CustomerStateEnum
{
    case Await;
    case Transition;
    case Arrived;
}
