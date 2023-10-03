<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'SimulationCommand',
    description: 'Simulation metro mapping',
)]
class SimulationCommand extends Command
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        MessageBusInterface         $messageBus
    )
    {
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        return Command::SUCCESS;
    }
}
